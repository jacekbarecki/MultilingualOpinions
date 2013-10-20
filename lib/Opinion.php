<?php
    require_once 'SqliteConnector.php';
    require_once 'GoogleTranslator.php';

    /**
     * Class responsible for fetching opinions and adding new
     * opinions.
     *
     * @package MultilingualOpinions
     * @version 0.1
     * @author Jacek Barecki
     *
     */
    class Opinion {

        /**
         * Instance of SqliteConnector
         *
         * @var SqliteConnector
         */
        private $_dbConn;

        /**
         * List of opinion languages, used when fetching
         * translations.
         *
         * @var array
         */
        private $_languages = array('en', 'fr', 'es');

        public function __construct() {
            $this->_dbConn = new SqliteConnector();
        }

        /**
         * Returns an array with all opinions and their translations.
         *
         * @return array
         */
        public function getAll() {
            $query = 'SELECT o.id as id, o.nick as nick, o.created as created, ot.text as text, ot.language as language, ot.machine as machine
                            FROM opinions o LEFT JOIN opinion_translations ot ON (o.id = ot.opinion_id) ORDER BY o.created DESC, o.id DESC, ot.machine ASC';
            try {
                $opinions = $this->_dbConn->db->query($query);
                $opinions_array = $opinions->fetchAll();
            }
            catch(Exception $e) {
                die('Unable to fetch opinions: ' . $e->getMessage());
            }

            $result = array();
            //Grouping by opinion_id
            for($i = 0; $i < count($opinions_array); $i++) {
                $result[$opinions_array[$i]['id']]['id'] = $opinions_array[$i]['id'];
                $result[$opinions_array[$i]['id']]['nick'] = (get_magic_quotes_gpc()) ? stripslashes($opinions_array[$i]['nick']) : $opinions_array[$i]['nick'];
                $result[$opinions_array[$i]['id']]['created'] = $opinions_array[$i]['created'];
                $result[$opinions_array[$i]['id']]['translations'][] = array(
                    'language' => $opinions_array[$i]['language'],
                    'text' => (get_magic_quotes_gpc()) ? stripslashes($opinions_array[$i]['text']) : $opinions_array[$i]['text'],
                    'machine' => $opinions_array[$i]['machine']
                );

                if(!$opinions_array[$i]['machine']) {
                    $result[$opinions_array[$i]['id']]['source_language'] = $opinions_array[$i]['language'];
                }
            }

            return $result;
        }


        /**
         * Adds an user submitted opinion.
         *
         * @param string $nick Nick
         * @param string $text Opinion text
         * @param string $language Opinion language (e.g. 'en')
         * @return int Created opinion ID
         */
        public function addOpinion($nick, $text, $language) {
            $query_opinion = 'INSERT INTO opinions (nick, created) VALUES (:nick, CURRENT_TIMESTAMP)';
            try {
                $stmt_opinion = $this->_dbConn->db->prepare($query_opinion);
                $stmt_opinion->execute(array(':nick'=> $nick));
                $opinion_id = $this->_dbConn->db->lastInsertId();

                $this->addTranslation($opinion_id, $language, $text, 0);
            }
            catch(Exception $e) {
                die('Unable to add an opinion: ' . $e->getMessage());
            }

            return $opinion_id;
        }

        /**
         * Adds a translation to an existing opinion.
         *
         * @param int $opinion_id Opinion ID
         * @param string $language Translation language (e.g. 'en')
         * @param string $text Translated text
         * @param int $machine 0|1 Is it a machine translation
         */
        public function addTranslation($opinion_id, $language, $text, $machine) {
            try {
                if($this->translationExists($opinion_id, $language, $machine)) {
                    throw new Exception('Such translation already exists.');
                }

                $query = 'INSERT INTO opinion_translations (opinion_id, language, machine, text) VALUES (:opinion_id, :language, :machine, :text)';
                $stmt = $this->_dbConn->db->prepare($query);
                $stmt->execute(array('opinion_id' => $opinion_id, 'language' => $language, 'machine' => $machine, 'text' => $text));
            }
            catch(Exception $e) {
                die('Unable to add a translation: ' . $e->getMessage());
            }
        }

        /**
         * Adds an opinion and auto-translates it to another languages
         * - defined in $this->_languages.
         *
         * @param string $nick Nick
         * @param string $text Opinion text
         * @param string $language Source language (e.g. 'en')
         */
        public function addOpinionAndTranslate($nick, $text, $language) {
            $opinion_id = $this->addOpinion($nick, $text, $language);

            foreach($this->_languages as $value) {
                if($language == $value) {
                    continue;
                }

                $translation = GoogleTranslator::translate($value, $text, $language);
                $this->addTranslation($opinion_id, $value, $translation, 1);
            }
        }


        /**
         * Checks whether a translation of a certain opinion exists.
         *
         * @param int $opinion_id Opinion ID
         * @param string $language Translation language (e.g. 'en')
         * @param int $machine 0|1 Is it a machine translation
         * @return bool True if such translation exists, false otherwise
         */
        public function translationExists($opinion_id, $language, $machine) {
            try {
                $query = 'SELECT count(*) FROM opinion_translations WHERE opinion_id = :id AND language = :language AND machine = :machine';
                $stmt = $this->_dbConn->db->prepare($query);
                $result = $stmt->execute(array(':id' => $opinion_id, ':language' => $language, ':machine' => $machine));
                $count = $stmt->fetchAll();
            }
            catch(Exception $e) {
                die('Unable to check whether the translation exists: ' . $e->getMessage());
            }

            return (isset($count[0][0]) && $count[0][0] > 0);
        }
    }
