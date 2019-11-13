<?php

    /**
     * Created by PhpStorm.
     * User: Mohammed Elamin
     * Date: 02/12/2018
     * Time: 03:29
     */
    class User extends Model
    {


        private $full_name;
        private $email;
        private $password;
        private $id;

        private $id_value = null;
        private $last_id = 0;

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }


        /**
         * User constructor.
         * @param $full_name
         * @param $email
         * @param $password
         */
        public function __construct()
        {
            Parent::__construct();
        }

        /**
         * @param mixed $full_name
         */
        public function setFullName($full_name)
        {
            $this->full_name = $full_name;
        }

        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }


        /**
         * @return mixed
         */
        public function getFullName()
        {
            return $this->full_name;
        }

        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }


        public function getUser($id)
        {
            if ($id > 0) {
                $doc = new DOMDocument;
                $doc->load('public/xml_data/user.xml');
                $xpath = new DOMXPath($doc);
                $name = $xpath->query("/Users//User[@ID='{$id}']/NAME");
                $email = $xpath->query("/Users//User[@ID='{$id}']/EMAIL");

                $user = new User();
                foreach ($name as $value) {
                    $user->setFullName($value->nodeValue);

                }

                foreach ($email as $value) {
                    $user->setEmail($value->nodeValue);

                }
                $user->setId($id);
                return $user;
            } else {
                return new User();
            }
        }


        public function save(User $user)
        {
            $allEmails = XmlProvider::getInstance()->getNodes('public/xml_data/user.xml', ['Users', 'User'], 'EMAIL');
            for ($i = 0; $i < sizeof($allEmails); $i++) {
                if ($allEmails[$i]==$user->getEmail())
                {
                    echo  'Email already used';
                    return false;

                }

            }
            XmlProvider::getInstance()->
            createNode('public/xml_data/user.xml',
                'Users', 'User'
                , XmlProvider::getInstance()->setUpNode(['NAME', 'EMAIL', 'PASSWORD'], [$user->getFullName(), $user->getEmail(), $user->getPassword()]),
                null, true);
            return true;

        }

        public function getTheLastId($path, $root, $node, $node_child)
        {
            $this->last_id = 0;
            $doc = new DOMDocument;
            $doc->load($path);

            $last_node = $node_child . '[last()]';

            $xpath = new DOMXPath($doc);
            $products = $xpath->query("/$root/$node/$last_node");
            foreach ($products as $product) {
                if ($product->nodeValue > 0) {
                    $this->last_id = $product->nodeValue;
                }
            }
            return $this->last_id;


        }


        public function login(User $user)
        {

            $password = Hash::passwordHashing($user->getPassword());

//            echo  Hash::passwordHashing('mohamed').'</br>';;
//
//            echo  $password.'</br>';
            $email = $user->getEmail();
            $doc = new DOMDocument;
            $doc->load('public/xml_data/user.xml');
            $xpath = new DOMXPath($doc);
            $products = $xpath->query("/Users/User[EMAIL='{$email}'  and PASSWORD='{$password}']/@ID");
            foreach ($products as $product) {
                $this->id_value = $product->nodeValue;
            }
            return $this->getUser($this->id_value);
        }


    }