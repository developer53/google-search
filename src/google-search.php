<?php
namespace SearchEngine;

class SearchEngine {

    private $_keywords;

    private $_engineName;

    private $_api_key;

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->_api_key = 'eea70e6bf6msh4acdd429cceeae1p1903ffjsn706c165f476c';

    }

    /**
     * Get API Key.
     * 
     * @return string
     */
    private function _getAPIKey() 
    {
        if (empty($this->_api_key)) {
            throw new Exception('API Key is required.');
        }

        return $this->_api_key;
        
    }

    /**
     * Set search engine.
     *
     * @param $name to get engine name.
     * 
     * @return void
     */
    public function setEngine( $name ) 
    {

        if ('google.ae' === $name) {
            $this->_engineName = 'ae';
        }
        
        if ('google.com' === $name) {
            $this->_engineName = 'us';
        }
    }

    /**
     * Get search engine.
     * 
     * @return string
     */
    private function _getEngine() 
    {
        if (empty($this->_engineName)) {
            throw new Exception('Please set search engine. ex: google.ae or google.com');
        }

        return $this->_engineName;
        
    }

    /**
     * Validate search keywords.
     * 
     * @param $keywords to validate.
     * 
     * @return array
     */
    private function _validateKeywords( $keywords ) 
    {
        if (! is_array($keywords) ) {
            throw new Exception('Pass keywords as an array.');
        }

        if (is_array($keywords) && count($keywords) <= 0 ) {
            throw new Exception('Please pass atleast one keywords to perform search.');
        }

        return $keywords;
    }

    /**
     * Start searching.
     *
     * @param $keywords pass multiple keywords to search on.
     * 
     * @return $results array.
     */
    public function search( $keywords = array() ) 
    {

        try {
            $data = array();
            $keywords = $this->_validateKeywords($keywords);
            $api_key = $this->_getAPIKey();
            $engine = $this->_getEngine();
            foreach ( $keywords as $keyword ) {                
                array_push( $data, self::_connection($api_key, $keyword, $engine) );                
            }

            return $data;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Connection for API Call.
     *
     * @param $api_key string 
     * @param $keyword string 
     * @param $search_country string 
     * @param $lang string 
     * 
     * @return $results array.
     */
    private static function _connection( $api_key, $keyword, $search_country, $lang = 'en' ) 
    {

        $curl = curl_init();

        $url = 'https://google-search1.p.rapidapi.com/google-search';

        $data = array(            
            'hl' => $lang,
            'q'  => $keyword,
            'gl' => $search_country,            
        );

        $request = $url . '?' . http_build_query($data); 

        curl_setopt_array(
            $curl, 
            array(
                CURLOPT_URL => $request,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "X-RapidAPI-Host: google-search1.p.rapidapi.com",
                    "X-RapidAPI-Key: " . $api_key
                ),
            )
        );

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            return $error;
        } else {
            return json_decode($response);
        }
    }
}
