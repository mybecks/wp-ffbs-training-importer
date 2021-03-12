<?php

/**
 * Handler for all database related requests
 */

//http://wordpress.stackexchange.com/questions/73868/queries-inside-of-a-class
class DatabaseHandler
{
    /** Refers to a single instance of this class. */
    private static $instance = null;
    private $table;

    /**
     * Creates or returns an instance of this class.
     *
     * @return A single instance of this class.
     * @author Andre Becker
     */
    public static function get_instance()
    {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->table = (object) array(
            "calendar" => $this->db->prefix . "my_calendar",
            "cal_cat_rel" => $this->db->prefix . "my_calendar_category_relationships",
            "cal_events" => $this->db->prefix . "my_calendar_events",
        );
    }
}
