<?php
/*
Plugin Name: FFBS Exercise Plan Importer
Plugin URI: https://github.com/mybecks/wp-ffbs-training-importer
Description: Exercise Plan Importer of FF Bad Schönborn
Version: 0.0.1
Author: FF Bad Schönborn
Author URI: ffbs.de
License: MIT
*/

define('MISSIONS_PLUGIN_DIR', plugin_dir_path(__FILE__));
require_once(MISSIONS_PLUGIN_DIR . 'class.ffbs-training-importer.php');
require_once(MISSIONS_PLUGIN_DIR . 'class.ffbs-training-importer-rest.php');
require_once(MISSIONS_PLUGIN_DIR . 'class.ffbs-training-importer-db.php');

$ffbsTrainingImporter = new FFBSTrainingImporter();
