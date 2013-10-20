<?php

    /**
     * Class SqliteConnector
     *
     * Simple PDO Sqlite connection wrapper.
     *
     * @package MultilingualOpinions
     * @version 0.1
     * @author Jacek Barecki
     */
    class SqliteConnector {

        /**
         * Database filename.
         *
         * @var string
         */
        private $_filename = 'opinions.db';

        /**
         * Instance of PDO representing a connection to the database.
         * Access it to perform database operations.
         *
         * @var
         */
        public $db;

        public function __construct() {
            try {
                $this->_init();
                $this->_createTables();
            }
            catch(Exception $e) {
                die('Error when initializing the database: ' . $e->getMessage());
            }
        }


        /**
         * Initializes a database connection.
         *
         */
        private function _init() {
            $this->db = new PDO('sqlite:' . $this->_filename);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->query('PRAGMA foreign_keys = ON');
        }

        /**
         * Creates the necessary tables, if they don't exist.
         *
         */
        private  function _createTables() {
            $create_opinions = 'CREATE TABLE IF NOT EXISTS opinions (id integer primary key, nick text, created integer)';
            $create_translations = 'CREATE TABLE IF NOT EXISTS opinion_translations (id integer primary key, opinion_id integer, language text, machine integer, text text,
                                        foreign key(opinion_id) references opinions(id))';

            $this->db->exec($create_opinions);
            $this->db->exec($create_translations);
        }
    }