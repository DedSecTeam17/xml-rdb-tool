<?php
/**
 * Created by PhpStorm.
 * User: Mohammed Elamin
 * Date: 01/12/2018
 * Time: 11:27
 */


class ToolController extends Controller
{
    public function __construct()
    {
        Parent::__construct('Phone');
    }


    public function xmlToRdbIndex()
    {

        return $this->view->render('tool.xml_to_rdb');
    }


//xmlToRdbIndex    rdbToXmlIndex


    public function rdbToXmlIndex()
    {

        $dbhost = 'localhost';
        $dbname = 'tool_db';
        $dbusername = 'root';
        $dbpassword = '';
        $link = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);


        $query = $link->prepare('show tables');
        $query->execute();


        $tables_names = array();
        while ($rows = $query->fetch(PDO::FETCH_ASSOC)) {
            array_push($tables_names, $rows['Tables_in_tool_db']);
        }


        return $this->view->render('tool.rdb_to_xml', $tables_names);
    }


    public function showTableContent($tableName)
    {

        $dbhost = 'localhost';
        $dbname = 'tool_db';
        $dbusername = 'root';
        $dbpassword = '';
        $link = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

        $query = $link->prepare("SELECT * FROM $tableName");
        $query->execute();
        $result = $query->fetchall();


//        print_r($result[0]);
        $table_attributes = array_keys($result[0]);


        function filter($item)
        {
            if (is_numeric($item)) {
                return false;
            } else {
                return true;
            }
        }

        $pure_attr = array_filter($table_attributes, "filter");


        return $this->view->render('tool.show_table_content', [
            "data" => $result,
            "table_name" => $tableName,
            "attr" => array_values($pure_attr)
        ]);
    }


    public function export($tableName)
    {

        $dbhost = 'localhost';
        $dbname = 'tool_db';
        $dbusername = 'root';
        $dbpassword = '';
        $link = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

        $query = $link->prepare("SELECT * FROM $tableName");
        $query->execute();
        $result = $query->fetchall();


//        print_r($result[0]);
        $table_attributes = array_keys($result[0]);


        function filter($item)
        {
            if (is_numeric($item)) {
                return false;
            } else {
                return true;
            }
        }

        $pure_attr = array_filter($table_attributes, "filter");



//        create xml  file
        $myfile = fopen("public/xml_data/$tableName.xml", "w") or die("Unable to open file!");
        fclose($myfile);


//        start write on xml file




        $attr= array_values($pure_attr);




        $dom = new DOMDocument();

        $dom->encoding = 'utf-8';

        $dom->xmlVersion = '1.0';

        $dom->formatOutput = true;

        $xml_file_name = "public/xml_data/$tableName.xml";

        $root = $dom->createElement($tableName."s");


    
        
        
        foreach($result as $row ){
            $first_node = $dom->createElement($tableName);


            for($i=0; $i<sizeof($attr); $i++){
                $child_node_title = $dom->createElement($attr[$i], $row[$attr[$i]]);

                $first_node->appendChild($child_node_title);
            }

            $root->appendChild($first_node);



        }

        $dom->appendChild($root);

        $dom->save($xml_file_name);




        return $this->view->render('tool.show_table_content', [
            "data" => $result,
            "message"=>"executed successfully ",
            "table_name"=>$tableName,
            "attr" => array_values($pure_attr)
        ]);
    }

    public function xmlToRdb()
    {


        $filePath = realpath($_FILES["xml_file"]["tmp_name"]);


        if ($filePath !== 'C:\xampp\htdocs\server_projects\XML-RDB-TOOL') {
            $contacts = simplexml_load_file($filePath);
            $table_name = $contacts->children()->getName();
            $item = $contacts->{$contacts->children()->getName()};
            $table_attr = array_keys(get_object_vars($item));


            $this->createTable($this->generateQuery($table_attr, $table_name));
            foreach ($contacts->{$contacts->children()->getName()} as $object) {
                $this->insertDataToTable(get_object_vars($object), $table_name);
            }

            return $this->view->render('tool.xml_to_rdb', [
                "message" => "xml converted  to relation data base successfully",
                "message_type" => "success",
                "attr" => $table_attr,
                "data" => $contacts
            ]);
        } else {
            return $this->view->render('tool.xml_to_rdb', [
                "message" => "please choose xml file",
                "message_type" => "error",
            ]);
        }


    }
    private function generateQuery($attr = array(), $tableName)
    {
        $query = " CREATE TABLE  ";
        $query .= $tableName . " ( ";

        for ($i = 0; $i < sizeof($attr); $i++) {
            $attribute = $attr[$i];

            if ($i === sizeof($attr) - 1) {
                $query .= $attribute . " VARCHAR(30) NOT NULL ) ";

            } else {
                $query .= $attribute . "  VARCHAR(30) NOT NULL , ";
            }

        }
        return $query;
    }

    private function createTable($query)
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tool_db";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($conn->query($query) === TRUE) {
//            echo "Table MyGuests created successfully";
        } else {
//            echo "Error creating table: " . $conn->error;
        }

        $conn->close();
    }

    private function insertDataToTable($data = array(), $tableName)
    {
        $dbhost = 'localhost';
        $dbname = 'tool_db';
        $dbusername = 'root';
        $dbpassword = '';
        $link = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));
        $sth = $link->prepare("INSERT INTO $tableName (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();

    }

    public function rdbToXml()
    {
        return $this->view->render('tool.rdb_to_xml');

    }

}