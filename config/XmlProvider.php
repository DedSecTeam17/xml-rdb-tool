<?php
    /**
     * Created by PhpStorm.
     * User: Mohammed Elamin
     * Date: 09/12/2018
     * Time: 05:11
     */

    class XmlProvider
    {

        /**
         * @var null
         */
        private static $instance = null;
        /**
         * @var
         */
        private $last_attribute;

        /**
         * XmlProvider constructor.
         */
        private function __construct()
        {

        }

        /**
         * @return XmlProvider|null
         */
        public static function getInstance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new XmlProvider();
            }
            return self::$instance;
        }


        /**
         * @param $path
         * @param $root
         * @param $node
         * @param $node_child
         * @return int
         */
        public function getTheLastAttributeValue($path, $root, $node, $node_child)
        {
            $this->last_attribute = 0;
            $doc = new DOMDocument;
            $doc->load($path);
            $last_node = '@'.$node_child . '[last()]';
            $xpath = new DOMXPath($doc);
            $products = $xpath->query("/$root/$node/$last_node");
            foreach ($products as $product) {
                if ($product->nodeValue > 0) {
                    $this->last_attribute = $product->nodeValue;
                }
            }
            return $this->last_attribute;

        }


        /**
         * @param array $tags
         * @param array $tags_value
         * @return array
         */
        public function setUpNode($tags = array(), $tags_value = array())
        {
            $node = array("node" => ["node_tags" => $tags, "node_values" => $tags_value]);
            return $node;
        }

        /**
         * @param array $attributes_names
         * @param array $attributes_values
         * @return array
         */
        public function setupAttributes($attributes_names = array(), $attributes_values = array())
        {
            $attributes = array("attributes" => ["attribute_name" => $attributes_names, "attribute_values" => $attributes_values]);
            return $attributes;
        }


        /**
         * @param $file_path
         * @param $root
         * @param $parent
         * @param array $node_data
         * @param array $attributes_data
         * @param bool $hasIdentifier
         */
        public function createNode($file_path, $root, $parent, $node_data = array(), $attributes_data = array(), $hasIdentifier = false)
        {

//            $data=$this->setUpNode(['NAME','age'],['mohammed',22]);
            $loaded_file = simplexml_load_file($file_path);
            $node = $loaded_file->addChild($parent);
//            if the node must have a unique  identifier this option must be true
            if ($hasIdentifier){
                $id=$this->getTheLastAttributeValue($file_path, $root, $parent, 'ID');
                $node->addAttribute("ID",++$id);
            }
            //            add attributes

            if ($attributes_data != null) {
                for ($i = 0; $i < sizeof($attributes_data['attributes']['attribute_name']); $i++) {
                    $attributes_name = $attributes_data['attributes']['attribute_name'][$i];
                    $attributes_value = $attributes_data['attributes']['attribute_values'][$i];
                    $node->addAttribute($attributes_name, $attributes_value);
                }
            }
//            add nodes
            for ($i = 0; $i < sizeof($node_data['node']['node_tags']); $i++) {
                $tag = $node_data['node']['node_tags'][$i];
                $tag_value = $node_data["node"]["node_values"][$i];
                $node->addChild($tag, $tag_value);
            }
            file_put_contents($file_path, $loaded_file->asXML());
        }


        /**
         * @param $file_path
         * @param array $path_to_node
         * @param $node
         * @return array
         */
        function getNodes($file_path, $path_to_node = array(), $node)
        {
            $nodes = array();

            $main_path = '/';
            for ($i = 0; $i < sizeof($path_to_node); $i++) {
                $nodez = $path_to_node[$i] . '/';
                $main_path .= $nodez;
            }
            $main_path .= $node;
            $doc = new DOMDocument;
            $doc->load($file_path);
            $xpath = new DOMXPath($doc);
            $quered_node = $xpath->query($main_path);
            foreach ($quered_node as $item) {
                array_push($nodes, $item->nodeValue);
            }
            return $nodes;
        }
        /**
         * @param $path
         * @param $node
         * @param $id
         */
        public function deleteNode($path,$node,$id)
        {
            $root = simplexml_load_file($path);
            $index = 0;
            $i = 0;
            foreach($root->{$node} as $_parent){
                if($_parent['ID']==$id){
                    $index = $i;
                    break;
                }
                $i++;
            }
            unset($root->{$node}[$index]);
            file_put_contents($path, $root->asXML());
        }


        /**
         *
         */
        public function updateNode()
        {

        }







        /**
         *
         */
        public function XmlQuery()
        {

        }

    }
