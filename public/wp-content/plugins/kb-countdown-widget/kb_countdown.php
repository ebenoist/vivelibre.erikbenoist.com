<?php
/*
Plugin Name: KB Countdown Widget
Description: Count the years/months/days since, until, or between events. Optional bar graph for tracking progress between two dates.
Author: Adam R. Brown
Version: 3.1.3
Plugin URI: http://adambrown.info/b/widgets/category/kb-countdown/
Author URI: http://adambrown.info/
*/


// SETTINGS
global $kbcountdown_bargraph_path; // don't change this
$kbcountdown_bargraph_path = ''; // optional. set url to bargraph file if the plugin has trouble finding it.




// all done!




/* Changelog (if you really want to track changes, use the svn repository)
	1.0	first version
 	1.1	add options to make translation of TIME_UNTIL and TIME_SINCE easy. Can now be localized from the Presentation => Sidebar Widgets screen.
	1.1.1	fix bug that kept bargraph from accepting border colors option
	1.5	Can now handle any date within 2,147,483,648 years of today. Also, significant improvements to how TIME_UNTIL and TIME_SINCE return dates.
	1.5.1	Make the code that finds the bargraph's URI more robust, plus an option for setting it manually just in case
	1.6	Add TOTAL_DAYS_SINCE and TOTAL_DAYS_UNTIL
	2.0	now works either as a widget or as a stand-alone plugin. See instructions (below) for use outside context of widgets. You'll need to set some options below.
	2.0.1	minor text changes to some default options
	2.1	improved handling of dates to avoid some time zone issues
	2.2	workaround for a WP v2.2 bug.
	2.3	More robust compatibility with WP 2.2.
	2.3.1	works with wp2.2.1. When will the developers quit screwing with the widgets api on every WP update? grrrrr
	2.3.2	for real this time
	2.3.3	typo
	3.0	completely rewritten using more efficient (object-oriented) coding. NOW REQUIRES PHP 5.
	3.0.1	Less stringent about the PHP 5 thing. Should work in PHP 4, actually, but I haven't tried.
	3.02	Made some changes, undid most, don't remember whether anything is different now since last version, and i'm too lazy to check. Here's to uploading anyway.
	3.03	Squish a couple bugs.
	3.1	Now with iCal support. (Requires the iCal Events plugin.)
	3.1.1	Minor CSS tweak
	3.1.2	Preparing for WP 2.5
	3.1.3	Bugfix. 
			84600 => 86400 on line 290.
			Incorrect leap year handling on 324
			Error in fix_days() threw off count spanning end of month
*/

/* INSTRUCTIONS:

	BASIC USE:
	Easiest way to use this plugin: After activation, go to the widgets management screen and configure the options. Voila.
	This plugin is primarily intended for use as a widget. See the previous sentence.


	Okay, here's the API, if you want to call it that.

	ADVANCED USES:
	This section is for people who know what they're doing.

	Overview: This plugin counts time since an event in the past, until an event in the future, or between a past and future event. For the latter use,
	the plugin can also produce a bargraph.


	ADVANCED USE #1: PLACE A COUNTDOWN SOMEWHERE IN YOUR THEME OR IN ANOTHER PLUGIN FILE
	Basically, advanced use #1 means anything that you place into a php file somewhere. Shoot, doesn't even need to be a wordpress app.
	The general idea is this: (1) You need to tell the class what dates you want, then (2) the class spits out the result. Let's talk about (1)
	for a moment. There's a couple ways to do this. First way is to pack your info into an array and pass as arg. Second way is to use a couple
	of the class's methods.
		= (1) as an array (easiest) =
			Create an array containing any or all of these keys (or just modify this array):
			*/
				global $kbcountdown_options_default;	// don't change this
				$kbcountdown_options_default = array(
					'title' => '',	// probably don't need this one.
					# message to be parsed.
					'message' => "KB Countdown has been awesome for TIME_SINCE. The world will end in TIME_UNTIL.",
					# translation from English, if desired
					'year' => 'year',
					'years' => 'years',
					'month' => 'month',
					'months' => 'months',
					'day' => 'day',
					'days' => 'days',
					'and' => 'and',
					# time values
					'startyear' => 2007,
					'startmonth' => 3,
					'startdate' => 28,
					'endyear' => 2107,
					'endmonth' => 3,
					'enddate' => 28,
					# bargraph size
					'kb_bargraph_width' => 100,
					'kb_bargraph_height' => 10,
					'kb_bargraph_border' => 1,
					# bargraph colors
					'kb_bargraph_bg' => '140,140,140',
					'kb_bargrapy_bar' => '0,0,255',
					'kb_bargraph_borderc' => '50,50,50'
				);
			/*
			Note that 'message' is strongly recommended. If you leave it out, you can still access the countdown data, but you'll need to look
			through the code yourself to figure out how.

			Next, start an instance of the class.
			$mycounter = new kbcountdown();
			
			Then, pass your array to the display() method. You can optionally tack "true" as a second arg if you want the countdown returned instead of printed.
			$mycounter->display( $myarray );
			
			All done.
		
		= (2) Using the class's methods =
			To use this approach, you don't need to define an array first. First, start an instance of the class:
			$mycounter = new kbcountdown();
			
			Set your start or end dates (or both) like this:
			$mycounter->set_start( 5, 8, 2005 );		// 5th of August 2005
			$mycounter->set_end( 28, 2, 2019 );		// 28th of February 2019
			
			Set a message to parse if you want:
			$mycounter->set_message( 'It has been TIME_SINCE since I got that new car.' );
			
			You can also set a title if you want using method set_title()
			
			Perform all the calculations using one (or both) of these methods:
			$mycounter->using_since();		// calculates count-up dates from a time in the past
			$mycounter->using_until();		// calculates count-down dates to a time in the future
			
			Echo whichever numbers you want. Look through the class for possibilities. Examples:
			echo $mycounter->years_since;
			echo $mycounter->months_since;
			echo $mycounter->days_since;
			echo $mycounter->total_days_since;
			echo $mycounter->time_since;		// returns the countdown in words, e.g. "3 years, 2 months, and 12 days."
			etc.......
			Note that these are the same as the "tags" available on the widgets menu, but in lower case.
	
	ADVANCED USE #2: PLACE A COUNTDOWN IN A POST OR PAGE
		I hope to make this easier in a later release. Really. Because this method is a pain in the rear. But here goes.
		Begin by reading the instructions for advanced use #1.
		Create an array variable as described above. Paste it into this file somewhere unobtrusive.
		Suppose your array is called $christmas2006 (because you're tracking up how long it's been since you got
		that cool new computer for Christmas in 2006 or something). Then you would write this in your post:
			^KBCOUNTDOWN||christmas2006$
		It will use the "message" key in the array and whatever dates you specify to print out your counter.
		Sorry it's not easier than that yet. Patience, patience, right?
*/

// whether you use this thing as a widget, in a php file, or whatever, the action is in this class.
class kbcountdown{
	var $options;
	var $message;
	var $title;

	var $bg_path;
	var $bargraph;
	
	var $now;
	var $start;
	var $startyear_adj = 0;
	var $end;
	var $endyear_adj = 0;
	var $years_since = 0;
	var $months_since = 0;
	var $days_since = 0;
	var $total_days_since = 0;
	var $years_until = 0;
	var $months_until = 0;
	var $days_until = 0;
	var $total_days_until = 0;
	var $percent_done = 0;

	// temp vars used within the class
	var $ty;
	var $tm;
	var $td;
	
	function set_now(){
		if ( ''!=$this->now ) // no need to do it twice
			return;
		// a weird workaround is necessary b/c of how WP handles dates and time zones. Start with the WP current time:
		$now = current_time('timestamp');
			// WP adds the GMT offset into current time twice, then removes it with gmdate. Weird.
			// let's apply gmdate now to get this into something normal.
		$this->now = mktime( gmdate('H', $now), gmdate('i', $now), gmdate('s', $now), gmdate('m', $now), gmdate('d', $now), gmdate('Y', $now));	// okay, use this.
	}
	
	function set_start($day=false,$month=false,$year=false){
		$day = $day ? $day : $this->options['startdate'];
		$month = $month ? $month : $this->options['startmonth'];
		$year = $year ? $year : $this->options['startyear'];

		if ( $year < 1971 ){	// workaround for a limitation in mktime()
			$this->startyear_adj = 1971 - $year;	// e.g. for 1960, this is 11
			$year = 1971;					// set start year to 1971. We'll add the 11 back in later.
		}
		$this->start = mktime( 0, 0, 0, $month, $day, $year);	// noon on chosen date
	}
	
	function set_end($day=false,$month=false,$year=false){
		$day = $day ? $day : $this->options['enddate'];
		$month = $month ? $month : $this->options['endmonth'];
		$year = $year ? $year : $this->options['endyear'];
		
		if ( $year > 2037 ){		// another workaround. Fix this before 2036 rolls around.
			$this->endyear_adj = $year - 2037;
			$year = 2037;
		}
		$this->end = mktime( 0, 0, 0, $month, $day, $year);
	}
	
	// for calling set_start or set_end with a unix timestamp. Defaults to set_start.
	function set_with_unix($timestamp,$start=true){
		$day = date("d",$timestamp);
		$month = date("m",$timestamp);
		$year = date("Y",$timestamp);
		if ($start)
			$this->set_start($day,$month,$year);
		else
			$this->set_end($day,$month,$year);
		$out = array($day,$month,$year); // return is mainly for the iCal stuff.
		return $out;
	}
	
	function find_bargraph(){
		global $kbcountdown_bargraph_path;
		if ( '' != $kbcountdown_bargraph_path ){
			$this->bg_path = $kbcountdown_bargraph_path;
			return;
		}
		// alright, then let's find the path to the bargraph file the hard way.
		$dir = dirname(__FILE__);
		if ( file_exists($dir . '/kb_countdown/kb_countdown_bargraph.php') ){
			$dir = substr( $dir, strpos($dir,'wp-content') );
			// for windows users:
			$dir = str_replace('\\', '/', $dir);
			$this->bg_path = get_settings('siteurl') . '/' . $dir . '/kb_countdown/kb_countdown_bargraph.php';
			return;
			/*	an older, less robust method:
			$this->bg_path = str_replace(ABSPATH, get_settings('siteurl').'/', dirname(__FILE__)) . '/kb_countdown/kb_countdown_bargraph.php';
			// above line would work fine if ABSPATH was always correct, but it's not. So let's code in a backup mechanism that might work in these funny cases.
			if ( $this->bg_path == (dirname(__FILE__) . '/kb_countdown/kb_countdown_bargraph.php') ){
				// so the str_replace must not have done anything. Here comes an ugly hack to provide a backup method.
				$this->bg_path = get_stylesheet_directory_uri();
				$this->bg_path = str_replace( substr($this->bg_path, strpos($this->bg_path, "wp-content/") ), '', $this->bg_path );
				// assumes user has plugin in the widgets directory. not necessarily true with wp 2.2+
				$this->bg_path = $this->bg_path . "wp-content/plugins/widgets/kb_countdown/kb_countdown_bargraph";
			}
			*/
		}else{
			$this->bg_path = null;
		}
	}
	
	function calculate($which="until"){
		if ( '' == $this->now )
			$this->set_now();

		// figure out which way we're counting
		if ( "until" == $which ){
			if ( '' == $this->end )
				$this->set_end();
			$earlier = $this->now;
			$later = $this->end;
			$date = $this->now;
			$yearadj = $this->endyear_adj;
		}else{
			if ( '' == $this->start )
				$this->set_start();
			$earlier = $this->start;
			$date = $earlier;
			$later = $this->now;
			$yearadj = $this->startyear_adj;
		}
		
		if ( $later < $earlier ){
			return; // defaults set previously in class to 0
		}
		
		$this->ty = date("Y", $later) - date("Y", $earlier);
		$this->ty = $this->ty + $yearadj;	// see the mktime workaround above for explanation

		$this->tm = date("n", $later) - date("n", $earlier);
		$this->fix_months();

		$this->td = date("j", $later) - date("j", $earlier);
		$this->fix_days($date);

		$total_days = number_format(round( ( ($later-$earlier) / 86400 ) + ($yearadj * 365.242) ));

		if ( "until" == $which ){
			$this->years_until = $this->ty;
			$this->months_until = $this->tm;
			$this->days_until = $this->td;
			$this->total_days_until = $total_days;
		}else{
			$this->years_since = $this->ty;
			$this->months_since = $this->tm;
			$this->days_since = $this->td;
			$this->total_days_since = $total_days;
		}
	}
	
	function fix_months(){
		if ( $this->tm >= 0 )
			return;
		$this->ty--;
		$this->tm = 12 + $this->tm;
	}
	
	function fix_days($date){ // $date should be the earlier of the two dates.
		if ($this->td >= 0)
			return;
		$this->tm--;
		$mo = date("n", $date);
		// figure out how many days are in the month
		if (1 == $mo || 3 == $mo || 5 == $mo || 7 == $mo || 8 == $mo || 10 == $mo || 12 == $mo){
			$this->td = 31 + $this->td;
		}elseif (2 == $mo){
			if ( date("L", $date) == 1){	// leap year
				$this->td = 29 + $this->td;
			}else{
				$this->td = 28 + $this->td;
			}
		}else{
			$this->td = 30 + $this->td;
		}
		$this->fix_months(); // need to do it again, since we changed the month earlier in this function.
	}
	
	// makes a pretty string out of time calculations. Produces $this->time_since or $this->time_until.
	function time_string($which="until"){ // indicate whether to use SINCE or UNTIL.
		
		if ( "until" == $which ){
			$yr = $this->years_until;
			$mo = $this->months_until;
			$da = $this->days_until;
		}else{ // presumably we want "since"
			$yr = $this->years_since;
			$mo = $this->months_since;
			$da = $this->days_since;
		}

		if ($yr > 1) 
			$years = "<strong>". number_format($yr) ."</strong> {$this->options['years']}";
		if ($yr == 1) 
			$years = "<strong>".$yr."</strong> {$this->options['year']}";
			
		if ($mo > 1)
			$months = "<strong>".$mo."</strong> {$this->options['months']}";
		if ($mo == 1) 
			$months = "<strong>".$mo."</strong> {$this->options['month']}";
			
		if ($da > 1 || $da == 0)
			$days = "<strong>".$da."</strong> {$this->options['days']}";
		if ($da == 1) 
			$days = "<strong>".$da."</strong> {$this->options['day']}";
		
		// figure out which ones we need for TIME_UNTIL (or TIME_SINCE) and tack them all together
		if ( ($da > 0) && ($mo > 0) && ($yr > 0) ){
			$out = "{$years}, {$months}, {$this->options['and']} {$days}";
		}elseif ( ($da > 0) && ($mo > 0) ){
			$out = "{$months} {$this->options['and']} {$days}";
		}elseif ( ($da > 0) && ($yr > 0) ){
			$out = "{$years} {$this->options['and']} {$days}";
		}elseif ( ($mo > 0) && ($yr > 0) ){
			$out = "{$years} {$this->options['and']} {$months}";
		}elseif ($mo > 0){
			$out = "{$months}";
		}elseif ($yr > 0){
			$out = "{$years}";
		}else{	// 0 time left, or less than one month left
			$out = "{$days}";
		}
		
		if ( "until" == $which ){
			$this->time_until = $out;
		}else{
			$this->time_since = $out;
		}
	}
	
	function calculate_percent(){
		if ( (''==$this->start) || (''==$this->end) || (''==$this->now) ) // require both
			return;
		// $this->percent_done has default of 0, so we don't need to test for condition that start time hasn't happened yet.
		if ( $this->now > $this->end ){
			$this->percent_done = 100;
			return;
		}
		if ( ($this->now < $this->end) && ($this->now > $this->start) ){ // we're between start and end times. good.
			// 32-bit processors only handle integers up to 2,147,483,648. That means we can only calculate precise percents if we're between 1970 and early 2038. 
			// if we're outside that range, calculate percents using years, not seconds. It will be less precise (slightly), but it will work.
			if ( $this->startyear_adj || $this->endyear_adj ){	// one of our dates was outside the range 1970 to 2038
				$this->percent_done = round( 100 * $this->years_since / ($this->years_until + $this->years_since) , 1);
			}else{	// we're within the range. Calculate precisely.
				$this->percent_done = round( 100 * ($this->now - $this->start) / ($this->end - $this->start) , 1);
			}
		}
	}
	
	function set_bargraph(){
		$this->find_bargraph();
		if ( $this->bg_path ){
			$this->bargraph = '<img src="' . $this->bg_path . '?done=' . $this->percent_done . '&amp;height=' . $this->options['bargraph_height'] . '&amp;width=' . $this->options['bargraph_width'] . '&amp;border=' . $this->options['bargraph_border'] . '&amp;border_c=' . $this->options['bargraph_borderc'] . '&amp;bar=' . $this->options['bargraph_bar'] . '&amp;bg=' . $this->options['bargraph_bg'] . '" alt="' . $this->percent_done . '% done" height="' . $this->options['bargraph_height'] . '" width="' . $this->options['bargraph_width'] . '" />';
		}else{
			$this->bargraph = "<b>the bargraph file is missing</b>";
		}
	}
	
	function using_since(){
		$this->calculate("since");
		$this->time_string("since");
	}
	
	function using_until(){
		$this->calculate("until");
		$this->time_string("until");
	}
	
	function needed(){ // figure out which calculations need to be done (and do them)
		$testphrase = $this->message . $this->title; // so we only need to do string searches once, not twice
		if ( false!==strpos($testphrase,"BARGRAPH") ){
			$graph = true; // we need everything
			$percent = true;
			$since = true;
			$until = true;
		}elseif( false!==strpos($testphrase,"PERCENT_DONE") ){
			$percent = true; // need everything but graph
			$since = true;
			$until = true;
		}else{ // not mutually exclusive, so test both
			if( false!==strpos($testphrase,"_SINCE") ){
				$since = true;
			}
			if( false!==strpos($testphrase,"_UNTIL") ){
				$until = true;
			}
		}
		if ( $since )
			$this->using_since();
		if ( $until )
			$this->using_until();
		if ( $percent ) // must follow since and until
			$this->calculate_percent();
		if ( $graph )
			$this->set_bargraph(); // must come after calculating percent done.
	}
	
	function set_message($msg=''){
		if (''!=$msg){
			$this->message = $msg;
			return;
		}
		if (''!=$this->message) // message has already been set. Let's not harass the database more than encessary.
			return;
		$this->message = $this->options['message'];
	}
	
	function set_title($title=''){
		if (''!=$title){
			$this->title = $title;
			return;
		}
		if (''!=$this->title) // leave the database alone if we can
			return;
		$this->title = $this->options['title'];
	}
	
	function write_message($calculated=false){ // set to TRUE to tell it not to re-calculate (unnecessary, but saves server load)
		// ensure message and title have been set
		$this->set_message();
		$this->set_title();
		
		// do all needed calculations, if they aren't already done
		if ( true!==$calculated )
			$this->needed();

		$messagein = array('YEARS_SINCE', 'MONTHS_SINCE', 'TOTAL_DAYS_SINCE', 'DAYS_SINCE', 'TIME_SINCE', 'YEARS_UNTIL', 'MONTHS_UNTIL', 'TOTAL_DAYS_UNTIL', 'DAYS_UNTIL', 'TIME_UNTIL', 'PERCENT_DONE', 'BARGRAPH');
		$messageout = array($this->years_since, $this->months_since, $this->total_days_since, $this->days_since, $this->time_since, $this->years_until, $this->months_until, $this->total_days_until, $this->days_until, $this->time_until, $this->percent_done, $this->bargraph);
		
		$this->message = str_replace($messagein, $messageout, $this->message);
		$this->title = str_replace($messagein, $messageout, $this->title);
	}
	
	function get_options($data=false){ // $data contains either (1) an array of options passed by user or (2) a widget ID #
		if ( is_array($data) ){ // user is providing data in a direct call
			$this->options = $data;
			return;
		}
		if ( !is_numeric($data) )
			$data = 1; // default to widget #1's options
		$this->options = get_option( 'widget_kbcountdown' );
		$this->options = $this->options[$data];
	}
	
	// to make the widget. If not using within widgets environment, use display() method instead.
	function widget($args,$number=1,$return=false){
		$this->get_options($number);
		if ('multi'==$this->options['mode']){
			$out .= $this->ical_widget($args);
		}else{ // a single event
			if ( is_array($args) )
				extract($args);
			$this->write_message();
			$out .= $before_widget;
			if ($this->title)
				$out .= $before_title . $this->title . $after_title;
			$out .= $this->message . $after_widget;
		}
		$out .= "<br>";

		if ($return)
			return $out;
		else
			echo $out;
	}
	
	function ical_widget($args=''){
		if (! class_exists('ICalEvents')) { // check for the iCal events plugin that we're piggybacking on
			$out .= $before_widget . $before_title . $this->title . $after_title;
			$out .= 'Error. You need the iCal Events plugin activated if you want to use an iCal source for the KB Countdown widget.';
			$out .= $after_widget;
			return $out;
		}
		$this->set_now();
		$events = ICalEvents::get_events($this->options['ical'], $this->now, null, $this->options['icalnum']);
		if (!is_array($events)){ // make sure iCal Events plugin is giving us something we can work with
			$out .= $before_widget . $before_title . $this->title . $after_title;
			// if you are getting the following message, THE BUG IS IN THE iCAL EVENTS PLUGIN. Trust me.
			$out .= 'Error. Your iCal source appears to be unavailable.';
			$out .= $after_widget;
			return $out;
		}
		// okay, let's display the sucker.
		if ( is_array($args) )
			extract($args);
		$this->set_title(); // so we can use it right now:
		if (1!=$this->options['icalsep']){ // repeat only the message (in a list); don't make a separate widget for each event
			$out .= $before_widget . $before_title . $this->title . $after_title . '<ul>';
		}
		// we need to grab a copy of the message
		$this->set_message(); // first we set it
		$msg = $this->message; // then we grab it
		// ditto for title
		$this->set_title();
		$tit = $this->title;

		// things we'll need to find and destroy:
		$find = array('SUMMARY','DESCRIPTION','LOCATION','DATE','MONTH','YEAR'); // from iCal data

		// the events loop
		foreach( $events as $event ){
			$d = $this->set_with_unix( $event['StartTime'], false ); // set the end time for this event
			$this->set_message( $msg ); // need to reset the message each time.
			$this->set_title( $tit );
			$this->using_until(); // do our calculations
			$this->write_message(false);
			$replace = array( $event['Summary'], $event['Description'], $event['Location'], $d[0], $d[1], $d[2] );
			$this->message = str_replace($find, $replace, $this->message);
			if (1!=$this->options['icalsep']){
				$out .= '<li>' . $this->message . '</li>';
			}else{
				$this->title = str_replace($find, $replace, $this->title);
				$out .= $before_widget . $before_title . $this->title . $after_title . $this->message . $after_widget;
			}
		}
		if (1!=$this->options['icalsep']){ // repeat only the message (in a list); don't make a separate widget for each event
			$out .= '</ul>' . $after_widget;
		}
		return $out;
	}
	
	// to call from theme files or from another plugin
	function display($data,$return=false){
		if ( !is_array($data) )
			return; // not even so much as an error message. It just won't do nuthin if you pass bad args. Heartless, isn't it?
		$this->get_options($data);
		$this->write_message();
		if ($return)
			return $this->message;
		else
			echo $this->message;
	}
}


// contains all functions necessary to use this thing as a widget (other than the preceding class, of course)
function widget_kbcountdown_init() {

	// to prevent fatal errors
	if ( !function_exists('register_sidebar_widget') )
		return;
		
	function widget_kbcountdown_control_javascript(){
		// javascripts for kbcountdown control
		
			/* 
			document.getElementById('kbcountdown-onedate-<?php echo $number; ?>').style.display='block';
			document.getElementById('kbcountdown-manydates-<?php echo $number; ?>').style.display='none';
			this.style.background='#ffa';
			document.getElementById('kbcountdown-manydates').style.background='#f9fcfe';
			document.getElementById('kbcountdown-switchto-single').style.display='block';
			document.getElementById('kbcountdown-advanced-bargraph').style.display='block';">
			
			document.getElementById('kbcountdown-onedate-<?php echo $number; ?>').style.display='none';document.getElementById('kbcountdown-manydates-<?php echo $number; ?>').style.display='block';this.style.background='#ffa';document.getElementById('kbcountdown-onedate').style.background='#f9fcfe';document.getElementById('kbcountdown-switchto-multi').style.display='block';document.getElementById('kbcountdown-advanced-bargraph').style.display='none';
			*/
		if (! class_exists('ICalEvents'))
			$addme = 'document.getElementById("kbcountdown-titlemessage-" + number).style.display="none";';
		else
			$addme = 'document.getElementById("kbcountdown-titlemessage-" + number).style.display="block";';

		echo '
			<style type="text/css"><!--
			.kbcountdown-nav{cursor:pointer;}
			// -->
			</style>
			<script type="text/javascript"><!--
			function kbcountdown_switchtab(to,number){
				if ("onedate"==to){
					// this tab
					document.getElementById("kbcountdown-onedate-" + number).style.display="block";
					document.getElementById("kbcountdown-onedatetab-" + number).style.background="#ffa";
					document.getElementById("kbcountdown-switchto-single-" + number).style.display="block";
					document.getElementById("kbcountdown-titlemessage-" + number).style.display="block";
					document.getElementById("kbcountdown-mode-" + number).value="single";
					// hide others
					document.getElementById("kbcountdown-manydates-" + number).style.display="none";
					document.getElementById("kbcountdown-manydatestab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-advanced-bargraph-" + number).style.display="none";
					document.getElementById("kbcountdown-bargraphtab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-translation-" + number).style.display="none";
					document.getElementById("kbcountdown-translationtab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-help-" + number).style.display="none";
					document.getElementById("kbcountdown-helptab-" + number).style.background="#f9fcfe";
				}
				if ("manydates"==to){
					// this tab
					document.getElementById("kbcountdown-manydates-" + number).style.display="block";
					document.getElementById("kbcountdown-manydatestab-" + number).style.background="#ffa";
					document.getElementById("kbcountdown-switchto-multi-" + number).style.display="block";
					'.$addme.'
					document.getElementById("kbcountdown-mode-" + number).value="multi";
					// hide others
					document.getElementById("kbcountdown-onedate-" + number).style.display="none";
					document.getElementById("kbcountdown-onedatetab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-advanced-bargraph-" + number).style.display="none";
					document.getElementById("kbcountdown-bargraphtab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-translation-" + number).style.display="none";
					document.getElementById("kbcountdown-translationtab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-help-" + number).style.display="none";
					document.getElementById("kbcountdown-helptab-" + number).style.background="#f9fcfe";
					}
				if ("bargraph"==to){
					// this tab
					document.getElementById("kbcountdown-advanced-bargraph-" + number).style.display="block";
					document.getElementById("kbcountdown-bargraphtab-" + number).style.background="#ffa";
					// hide others
					document.getElementById("kbcountdown-onedate-" + number).style.display="none";
					document.getElementById("kbcountdown-onedatetab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-manydates-" + number).style.display="none";
					document.getElementById("kbcountdown-manydatestab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-titlemessage-" + number).style.display="none";
					document.getElementById("kbcountdown-translation-" + number).style.display="none";
					document.getElementById("kbcountdown-translationtab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-help-" + number).style.display="none";
					document.getElementById("kbcountdown-helptab-" + number).style.background="#f9fcfe";
				}
				if ("translate"==to){
					// this tab
					document.getElementById("kbcountdown-translation-" + number).style.display="block";
					document.getElementById("kbcountdown-translationtab-" + number).style.background="#ffa";
					// hide others
					document.getElementById("kbcountdown-onedate-" + number).style.display="none";
					document.getElementById("kbcountdown-onedatetab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-manydates-" + number).style.display="none";
					document.getElementById("kbcountdown-manydatestab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-titlemessage-" + number).style.display="none";
					document.getElementById("kbcountdown-advanced-bargraph-" + number).style.display="none";
					document.getElementById("kbcountdown-bargraphtab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-help-" + number).style.display="none";
					document.getElementById("kbcountdown-helptab-" + number).style.background="#f9fcfe";
				}
				if ("help"==to){
					// this tab
					document.getElementById("kbcountdown-help-" + number).style.display="block";
					document.getElementById("kbcountdown-helptab-" + number).style.background="#ffa";
					// hide others
					document.getElementById("kbcountdown-onedate-" + number).style.display="none";
					document.getElementById("kbcountdown-onedatetab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-manydates-" + number).style.display="none";
					document.getElementById("kbcountdown-manydatestab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-titlemessage-" + number).style.display="none";
					document.getElementById("kbcountdown-advanced-bargraph-" + number).style.display="none";
					document.getElementById("kbcountdown-bargraphtab-" + number).style.background="#f9fcfe";
					document.getElementById("kbcountdown-translation-" + number).style.display="none";
					document.getElementById("kbcountdown-translationtab-" + number).style.background="#f9fcfe";
				}
			}
			// -->
			</script>
		';
	}

	function widget_kbcountdown_control($number) {
		$options = $newoptions = get_option('widget_kbcountdown');

		if ( $_POST["kbcountdown-submit-$number"] ) {
			$newoptions[$number]['title'] = trim(strip_tags(stripslashes($_POST["kbcountdown-title-$number"])));
			$newoptions[$number]['years'] = trim(strip_tags(stripslashes($_POST["kbcountdown-years-$number"])));
				if ( '' == $newoptions[$number]['years']){	$newoptions[$number]['years'] == 'years'; }
			$newoptions[$number]['year'] = trim(strip_tags(stripslashes($_POST["kbcountdown-year-$number"])));
				if ( '' == $newoptions[$number]['year']){	$newoptions[$number]['year'] == 'year'; }
			$newoptions[$number]['months'] = trim(strip_tags(stripslashes($_POST["kbcountdown-months-$number"])));
				if ( '' == $newoptions[$number]['months']){	$newoptions[$number]['months'] == 'months'; }
			$newoptions[$number]['month'] = trim(strip_tags(stripslashes($_POST["kbcountdown-month-$number"])));
				if ( '' == $newoptions[$number]['month']){	$newoptions[$number]['month'] == 'month'; }
			$newoptions[$number]['days'] = trim(strip_tags(stripslashes($_POST["kbcountdown-days-$number"])));
				if ( '' == $newoptions[$number]['days']){	$newoptions[$number]['days'] == 'days'; }
			$newoptions[$number]['day'] = trim(strip_tags(stripslashes($_POST["kbcountdown-day-$number"])));
				if ( '' == $newoptions[$number]['day']){	$newoptions[$number]['day'] == 'day'; }
			$newoptions[$number]['and'] = trim(strip_tags(stripslashes($_POST["kbcountdown-and-$number"])));
				if ( '' == $newoptions[$number]['and']){	$newoptions[$number]['and'] == 'and'; }
			
			// for single-date mode
			$newoptions[$number]['startmonth'] = (int) $_POST["kbcountdown-startmonth-$number"];
			$newoptions[$number]['startdate'] = (int) $_POST["kbcountdown-startdate-$number"];
			$newoptions[$number]['startyear'] = (int) $_POST["kbcountdown-startyear-$number"];
			$newoptions[$number]['endmonth'] = (int) $_POST["kbcountdown-endmonth-$number"];
			$newoptions[$number]['enddate'] = (int) $_POST["kbcountdown-enddate-$number"];
			$newoptions[$number]['endyear'] = (int) $_POST["kbcountdown-endyear-$number"];
			
			// for multi-date mode
			$newoptions[$number]['ical'] = trim(strip_tags(stripslashes($_POST["kbcountdown-ical-$number"])));
			$newoptions[$number]['icalnum'] = (int) $_POST["kbcountdown-icalnum-$number"];
			$newoptions[$number]['icalsep'] = (1==$_POST["kbcountdown-icalsep-$number"]) ? 1 : 0;
			
			// this isn't entirely necessary, since the bargraph.php file will scrub its inputs. But just to make things easier on the end user... ("huh? why can't I just type 'big'?")
			$newoptions[$number]['bargraph_width'] = is_numeric($_POST["kbcountdown-bargraph-width-$number"]) ? $_POST["kbcountdown-bargraph-width-$number"] : 100;
			$newoptions[$number]['bargraph_width'] = ( $newoptions[$number]['bargraph_width'] < 10 ) ? 10 : $newoptions[$number]['bargraph_width'];
			$newoptions[$number]['bargraph_height'] = is_numeric($_POST["kbcountdown-bargraph-height-$number"]) ? $_POST["kbcountdown-bargraph-height-$number"] : 10;
			$newoptions[$number]['bargraph_height'] = ( $newoptions[$number]['bargraph_height'] < 1 ) ? 1 : $newoptions[$number]['bargraph_height'];
			$newoptions[$number]['bargraph_border'] = is_numeric($_POST["kbcountdown-bargraph-border-$number"]) ? $_POST["kbcountdown-bargraph-border-$number"] : 1;
			
			// not going to scrub these. just let the bargraph.php file do it.
			$newoptions[$number]['bargraph_bg'] = strip_tags($_POST["kbcountdown-bargraph-bg-$number"]);
			$newoptions[$number]['bargraph_bar'] = strip_tags($_POST["kbcountdown-bargraph-bar-$number"]);
			$newoptions[$number]['bargraph_borderc'] = strip_tags($_POST["kbcountdown-bargraph-borderc-$number"]);
			
			// the message
			$newoptions[$number]['message'] = stripslashes($_POST["kbcountdown-message-$number"]);
			if ( !current_user_can('unfiltered_html') )
				$newoptions[$number]['message'] = stripslashes(wp_filter_post_kses($newoptions[$number]['message']));
			
			// single or multi date mode?
			$newoptions[$number]['mode'] = ('multi'==$_POST["kbcountdown-mode-$number"]) ? 'multi' : 'single';
		}
		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_kbcountdown', $options);
		}
		
		$title = htmlspecialchars($options[$number]['title'], ENT_QUOTES);
		$message = htmlspecialchars($options[$number]['message'], ENT_QUOTES);
		
		if ( (''==$message) && (''==$title) ) // check both before inserting default
			$message = "It happened TIME_SINCE ago. It will happen in TIME_UNTIL.<br />BARGRAPH";
		
		// it's not necessary to populate these (will default to English) but this will help users figure out how to localize
		if ( empty($options[$number]['years'] ) )
			$options[$number]['years'] = 'years';
		if ( empty($options[$number]['year'] ) )
			$options[$number]['year'] = 'year';
		if ( empty($options[$number]['months'] ) )
			$options[$number]['months'] = 'months';
		if ( empty($options[$number]['month'] ) )
			$options[$number]['month'] = 'month';
		if ( empty($options[$number]['days'] ) )
			$options[$number]['days'] = 'days';
		if ( empty($options[$number]['day'] ) )
			$options[$number]['day'] = 'day';
		if ( empty($options[$number]['and'] ) )
			$options[$number]['and'] = 'and';

		// it's not necessary to populate any of the following fields (bargraph.php will take care of it), but this makes it easier for users to figure out how to use their options
		if ( empty($options[$number]['bargraph_width'] ) )
			$options[$number]['bargraph_width'] = 100;
		if ( empty($options[$number]['bargraph_height'] ) )
			$options[$number]['bargraph_height'] = 10;
		if ( empty($options[$number]['bargraph_border'] ) )
			$options[$number]['bargraph_border'] = 1;
		if ( empty($options[$number]['bargraph_bar'] ) )
			$options[$number]['bargraph_bar'] = "0,0,255";
		if ( empty($options[$number]['bargraph_borderc'] ) )
			$options[$number]['bargraph_borderc'] = "50,50,50";
		if ( empty($options[$number]['bargraph_bg'] ) )
			$options[$number]['bargraph_bg'] = "140,140,140";
		
		if ( empty($options[$number]['mode'] ) )
			$options[$number]['mode'] = 'single';
		$ical = (''!=$options[$number]['ical']) ? $options[$number]['ical'] : 'http://www.google.com/calendar/ical/ht3jlfaac5lfd6263ulfh4tql8%40group.calendar.google.com/public/basic.ics'; // phases of the moon
		if ( empty($options[$number]['icalnum']) )
			$options[$number]['icalnum'] = 3;
		
		?>
			<div class='kbcountdown-nav' style="border-bottom:solid 1px #000;">
				&nbsp; 
				<span id='kbcountdown-onedatetab-<?php echo $number; ?>' style="border:solid 1px #000;padding:0 0.3em;<?php if ('multi'!=$options[$number]['mode']){echo 'background:#ffa;'; } ?>" onclick="kbcountdown_switchtab('onedate','<?php echo $number; ?>');">Single-Date Mode</span> 
				&nbsp; 
				<span id='kbcountdown-manydatestab-<?php echo $number; ?>' style="border:solid 1px #000;padding:0 0.3em;<?php if ('multi'==$options[$number]['mode']){echo 'background:#ffa;'; } ?>" onclick="kbcountdown_switchtab('manydates','<?php echo $number; ?>');">Multi-Date Mode</span> 
				&nbsp; 
				<span id='kbcountdown-bargraphtab-<?php echo $number; ?>' style="border:solid 1px #000;padding:0 0.3em;" onclick="kbcountdown_switchtab('bargraph','<?php echo $number; ?>');">Bargraph Options</span> 
				&nbsp; 
				<span id='kbcountdown-translationtab-<?php echo $number; ?>' style="border:solid 1px #000;padding:0 0.3em;" onclick="kbcountdown_switchtab('translate','<?php echo $number; ?>');">Non-English</span> 
				&nbsp; 
				<span id='kbcountdown-helptab-<?php echo $number; ?>' style="border:solid 1px #000;padding:0 0.3em;" onclick="kbcountdown_switchtab('help','<?php echo $number; ?>');">Help</span> 
				</div>

			<div id='kbcountdown-onedate-<?php echo $number; ?>' <?php if ('multi'==$options[$number]['mode']){echo 'style="display:none;"'; } ?>>
				<p>&nbsp;</p>
				<p id='kbcountdown-switchto-single-<?php echo $number; ?>'><big><strong>You are using single-date mode</strong></big></p>
				<p>&nbsp;</p>
				<p><b>Give a start date, an end date, or both.</b> (Use -600 for 600BC.)</p>

				<p>Start date (month-day-year): <select name="kbcountdown-startmonth-<?php echo $number; ?>" id="kbcountdown-startmonth-<?php echo $number; ?>">
				<?php for($i = 1; $i <= 12; $i++){
						if ( $i == $options[$number]['startmonth'] )
							print '<option selected="selected">';
						else
							print '<option>';
						print $i . "</option>\n";
				} ?>
				</select> <select name="kbcountdown-startdate-<?php echo $number; ?>" id="kbcountdown-startdate-<?php echo $number; ?>">
				<?php for($i = 1; $i <= 31; $i++){
						if ( $i == $options[$number]['startdate'] )
							print '<option selected="selected">';
						else
							print '<option>';
						print $i . "</option>\n";
				} ?>
				</select> <input style="width: 60px;" type="text" name="kbcountdown-startyear-<?php echo $number; ?>" id="kbcountdown-startyear-<?php echo $number; ?>" value="<?php echo $options[$number]['startyear']; ?>" />
				</p>
				
				<p>End date (month-day-year): <select name="kbcountdown-endmonth-<?php echo $number; ?>" id="kbcountdown-endmonth-<?php echo $number; ?>">
				<?php for($i = 1; $i <= 12; $i++){
						if ( $i == $options[$number]['endmonth'] )
							print '<option selected="selected">';
						else
							print '<option>';
						print $i . "</option>\n";
				} ?>
				</select> <select name="kbcountdown-enddate-<?php echo $number; ?>" id="kbcountdown-enddate-<?php echo $number; ?>">
				<?php for($i = 1; $i <= 31; $i++){
						if ( $i == $options[$number]['enddate'] )
							print '<option selected="selected">';
						else
							print '<option>';
						print $i . "</option>\n";
				} ?>
				</select> <input style="width: 60px;" type="text" name="kbcountdown-endyear-<?php echo $number; ?>" id="kbcountdown-endyear-<?php echo $number; ?>" value="<?php echo $options[$number]['endyear']; ?>" />
				</p>
				<p>&nbsp;</p>
				<p>In your title and message, insert TIME_SINCE, TIME_UNTIL, PERCENT_DONE, or BARGRAPH where appropriate.</p>
			</div><!--#onedate-->


			<div id='kbcountdown-manydates-<?php echo $number; ?>' <?php if ('multi'!=$options[$number]['mode']){echo 'style="display:none;"'; } ?>>
				<p>&nbsp;</p>
				<p id='kbcountdown-switchto-multi-<?php echo $number; ?>'><big><strong>You are using multi-date (calendar) mode.</strong></big></p>
				<?php
					if (! class_exists('ICalEvents')) {
						echo '<p>Sorry, but you cannot use Multi-Date mode unless you also have the <a href="http://wordpress.org/extend/plugins/ical-events/">ICal Events</a> plugin installed. You don\'t need to have it configured or doing anything else, but you do need to upload it to your Wordpress plugins directory and then activate it in the usual manner.</p>
							<p>In multi-date mode, you provide a link to an ICal source (such as a Google Calendar). The KB Countdown widget will display countdowns to the next few events on your calendar. Note that there are a few differences between single-date and multi-date mode. In single-date mode, you can count down the days <i>until</i> an event, count up the days <i>since</i> an event, or track the time <i>between</i> two events. In multi-date mode, you can only count down the days until a future event.</p>
							<p>If that sounds interesting, go download the ICal events plugin now.</p>
							<p>Disclaimer: The author of the KB Countdown widget has no connection whatsoever to the authors of the ICal events plugin. If you have problems with the ICal plugin, contact the ICal Events author.</p>
						';
					}else{
						?>
						<p>URL to an iCal source (to be parsed by iCal Events plugin)</p>
						<p><input style="width:750px;" id="kbcountdown-ical-<?php echo $number; ?>" name="kbcountdown-ical-<?php echo $number; ?>" type="text" value="<?php echo $ical; ?>" /></p>
						<table>
							<tr>
								<td><p style="text-align:left;">Number of events to display: 
									<select id="kbcountdown-icalnum-<?php echo $number; ?>" name="kbcountdown-icalnum-<?php echo $number; ?>">
									<?php
										for($i = 1; $i <= 10; $i++){
											if ( $i == $options[$number]['icalnum'] )
												print '<option selected="selected">';
											else
												print '<option>';
											print $i . "</option>\n";
										}
									?>
									</select> &nbsp; &nbsp;</p>
								</td>
								<td>
									<p style="text-align:left;"><input type="radio" id="kbcountdown-icalsep-<?php echo $number; ?>" name="kbcountdown-icalsep-<?php echo $number; ?>" value="0" <?php if ("1"!=$options[$number]['icalsep']){echo 'checked="checked"';} ?> /> Repeat the <i>message</i> (below) for each event<br />
									<input type="radio" id="kbcountdown-icalsep-<?php echo $number; ?>" name="kbcountdown-icalsep-<?php echo $number; ?>" value="1" <?php if ("1"==$options[$number]['icalsep']){echo 'checked="checked"';} ?> /> Repeat the <i>message and title</i> (as if each event were a separate widget)</p>
								</td>
							</tr>
						</table>
						<p style="text-align:left;">Insert the countdown until an event using TIME_UNTIL. Insert information about an event (from the iCal file) using SUMMARY, DESCRIPTION, LOCATION, MONTH, DATE, and YEAR.</p>


						<?php
					}
				?>
			</div><!--#manydates-->

			<div id='kbcountdown-titlemessage-<?php echo $number; ?>' <?php if ( ('multi'==$options[$number]['mode']) && (!class_exists('ICalEvents')) ){echo 'style="display:none;"'; } ?>>
				<p><input style="width:750px;" id="kbcountdown-title-<?php echo "$number"; ?>" name="kbcountdown-title-<?php echo "$number"; ?>" type="text" value="<?php echo $title; ?>" /></p>

				<div style="text-align:center;"><textarea style="width:750px;height:100px;" rows="3" cols="50" id="kbcountdown-message-<?php echo "$number"; ?>" name="kbcountdown-message-<?php echo "$number"; ?>"><?php echo $message; ?></textarea></div>
			</div>

				<div id='kbcountdown-advanced-bargraph-<?php echo $number; ?>' style='display:none'>
					<p>&nbsp;</p>
					<p style="text-align:center;"><big><b>Advanced bargraph options</b>. Delete to restore defaults.</big></p>
					<p>Note that bargraphs can be used only in single-event mode.</p>
					<table style="width:100%;">
					<tr>
						<td style="width:12%;">Width: </td><td style="width:17%;"><input type="text" style="width:50px;" name="kbcountdown-bargraph-width-<?php echo $number; ?>" id="kbcountdown-bargraph-width-<?php echo $number; ?>" value="<?php echo $options[$number]['bargraph_width'] ?>" /> pixels. &nbsp;</td><td style="width:6%;"> &nbsp; </td>
						<td style="width:13%;">Height: </td><td style="width:17%;"><input type="text" style="width:50px;" name="kbcountdown-bargraph-height-<?php echo $number; ?>" id="kbcountdown-bargraph-height-<?php echo $number; ?>" value="<?php echo $options[$number]['bargraph_height']; ?>" /> pixel(s). &nbsp;</td><td style="width:6%;"> &nbsp; </td>
						<td style="width:12%;">Border: </td><td style="width:17%;"><input type="text" style="width:50px;" name="kbcountdown-bargraph-border-<?php echo $number; ?>" id="kbcountdown-bargraph-border-<?php echo $number; ?>" value="<?php echo $options[$number]['bargraph_border']; ?>" /> pixel(s). &nbsp;</td></tr>
					<tr>
						<td>Bar (R,G,B): </td><td><input type="text" style="width:70px;" name="kbcountdown-bargraph-bar-<?php echo $number; ?>" id="kbcountdown-bargraph-bar-<?php echo $number; ?>" value="<?php echo $options[$number]['bargraph_bar']; ?>" /> </td><td> </td>
						<td>Background: </td><td><input type="text" style="width:70px;" name="kbcountdown-bargraph-bg-<?php echo $number; ?>" id="kbcountdown-bargraph-bg-<?php echo $number; ?>" value="<?php echo $options[$number]['bargraph_bg']; ?>" /></td><td> </td>
						<td>Border: </td><td><input type="text" style="width:70px;" name="kbcountdown-bargraph-borderc-<?php echo $number; ?>" id="kbcountdown-bargraph-borderc-<?php echo $number; ?>" value="<?php echo $options[$number]['bargraph_borderc']; ?>" /></td>
					</tr>
					</table>
					<p>&nbsp;</p>
				</div><!--#advanced-bargraph-->


				<div id='kbcountdown-translation-<?php echo $number; ?>' style='display:none'>
					<p>&nbsp;</p>
					<p style="text-align:center;"><big><b>Translation from English</b>. Delete to restore defaults.</big></p>
					<table style="width:100%;">
					<tr>
						<td style="width:10%;">years: </td><td style="width:15%;"><input type="text" style="width:60px;" name="kbcountdown-years-<?php echo $number; ?>" id="kbcountdown-years-<?php echo $number; ?>" value="<?php echo $options[$number]['years']; ?>" /> &nbsp;</td>
						<td style="width:10%;">year: </td><td style="width:15%;"><input type="text" style="width:60px;" name="kbcountdown-year-<?php echo $number; ?>" id="kbcountdown-year-<?php echo $number; ?>" value="<?php echo $options[$number]['year']; ?>" /> &nbsp;</td>
						<td style="width:10%;">months: </td><td style="width:15%;"><input type="text" style="width:60px;" name="kbcountdown-months-<?php echo $number; ?>" id="kbcountdown-months-<?php echo $number; ?>" value="<?php echo $options[$number]['months']; ?>" /> &nbsp;</td>
						<td style="width:10%;">month: </td><td style="width:15%;"><input type="text" style="width:60px;" name="kbcountdown-month-<?php echo $number; ?>" id="kbcountdown-month-<?php echo $number; ?>" value="<?php echo $options[$number]['month']; ?>" /></td>
					</tr>
					<tr>
						<td>days: </td><td><input type="text" style="width:60px;" name="kbcountdown-days-<?php echo $number; ?>" id="kbcountdown-days-<?php echo $number; ?>" value="<?php echo $options[$number]['days']; ?>" /> &nbsp;</td>
						<td>day: </td><td><input type="text" style="width:60px;" name="kbcountdown-day-<?php echo $number; ?>" id="kbcountdown-day-<?php echo $number; ?>" value="<?php echo $options[$number]['day']; ?>" /> &nbsp;</td>
						<td>and: </td><td><input type="text" style="width:60px;" name="kbcountdown-and-<?php echo $number; ?>" id="kbcountdown-and-<?php echo $number; ?>" value="<?php echo $options[$number]['and']; ?>" /></td>
						<td> </td><td> </td>
					</tr>
					</table>
					<p>&nbsp;</p>
				</div>
				
				<div id='kbcountdown-help-<?php echo $number; ?>' style="display:none;">
					<p><big><strong>Quick Help Tips</strong></big></p>
					<p style="text-align:left;">Some of the counting tags you can use (see FAQ for more): TIME_UNTIL, TIME_SINCE, TOTAL_DAYS_UNTIL, TOTAL_DAYS_SINCE, BARGRAPH, PERCENT_DONE. You can use only the _UNTIL tags in multi-date mode.</p>
					<p style="text-align:left;">In multi-date mode, you can use event information tags also: SUMMARY, DESCRIPTION, LOCATION, MONTH, DATE, YEAR. Note that many calendars you find on the internet will not have a "description" or "location."</p>
					<p style="text-align:left;">If you are using multi-date mode and getting errors (things like "Unknown repeat interval"), the errors are caused by the <a href="http://wordpress.org/extend/plugins/ical-events/">iCal Events plugin</a>, so you'll need to ask that plugin's developers for help. Also, if you're wondering why your iCal data doesn't appear to be updating, that's because the iCal Events plugin caches calendar data for 24 hours by default.</p>
					<p><big><strong>Still Need Help?</strong></big></p>
					<p style="text-align:left;">Start with the <a href="http://wordpress.org/extend/plugins/kb-countdown-widget/faq/">FAQ</a>. If you're still stumped, click the "get help" link below and write a comment on my blog.</p>
					<p>&nbsp;</p>
				</div>

				<p><b>Need help with this widget?</b> <a href="http://adambrown.info/b/widgets/category/kb-countdown/">Get help</a>.</p>
				<input type="hidden" id="kbcountdown-mode-<?php echo $number; ?>" name="kbcountdown-mode-<?php echo $number; ?>" value="<?php echo $options[$number]['mode']; ?>" />
				<input type="hidden" id="kbcountdown-submit-<?php echo "$number"; ?>" name="kbcountdown-submit-<?php echo "$number"; ?>" value="1" />
	<?php
	}

	function widget_kbcountdown_setup() {
		$options = $newoptions = get_option('widget_kbcountdown');
		if ( isset($_POST['kbcountdown-number-submit']) ) {
			$number = (int) $_POST['kbcountdown-number'];
			if ( $number > 9 ) $number = 9;
			if ( $number < 1 ) $number = 1;
			$newoptions['number'] = $number;
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_kbcountdown', $options);
			widget_kbcountdown_register($options['number']);
		}
	}

	function widget_kbcountdown_page() {
		$options = $newoptions = get_option('widget_kbcountdown');
	?>
		<div class="wrap">
			<form method="POST">
				<h2><?php _e('KB Countdown Widgets', 'widgets'); ?></h2>
				<p style="line-height: 30px;"><?php _e('How many KB Countdown widgets would you like?', 'widgets'); ?>
				<select id="kbcountdown-number" name="kbcountdown-number" value="<?php echo $options['number']; ?>">
	<?php for ( $i = 1; $i < 10; ++$i ) echo "<option value='$i' ".($options['number']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
				<span class="submit"><input type="submit" name="kbcountdown-number-submit" id="kbcountdown-number-submit" value="<?php _e('Save'); ?>" /></span></p>
			</form>
		</div>
	<?php
	}

	function widget_kbcountdown_register() {
		global $wp_version;
		$options = get_option('widget_kbcountdown');
		$number = $options['number'];
		if ( $number < 1 ) $number = 1;
		if ( $number > 9 ) $number = 9;
		for ($i = 1; $i <= 9; $i++) {
			$name = array('KB Countdown %s', 'widgets', $i);
			$height = 550;
			$width = 800;
			if ( '2.2' == $wp_version ){
				register_sidebar_widget($name, $i <= $number ? 'widget_kbcountdown' : /* unregister */ '', '', $i);
				register_widget_control($name, $i <= $number ? 'widget_kbcountdown_control' : /* unregister */ '', $width, $height, $i);
			}elseif ( function_exists( 'wp_register_sidebar_widget' ) ){	// we're using v2.2.1+ here
				$id = "kb-countdown-$i"; // Never never never translate an id
				$dims = array('width' => $width, 'height' => $height);
				$class = array( 'classname' => 'widget_kbcountdown' ); // css classname
				$name = sprintf(__('KB Countdown %d'), $i);
				wp_register_sidebar_widget($id, $name, $i <= $number ? 'widget_kbcountdown' : /* unregister */ '', $class, $i);
				wp_register_widget_control($id, $name, $i <= $number ? 'widget_kbcountdown_control' : /* unregister */ '', $dims, $i);
			}else{ // pre-2.2 (widgets as a plugin)
				register_sidebar_widget($name, $i <= $number ? 'widget_kbcountdown' : /* unregister */ '', $i);
				register_widget_control($name, $i <= $number ? 'widget_kbcountdown_control' : /* unregister */ '', $width, $height, $i);
			}	
		}
		add_action('sidebar_admin_setup', 'widget_kbcountdown_setup');
		add_action('sidebar_admin_page', 'widget_kbcountdown_page');
		add_action('admin_head', 'widget_kbcountdown_control_javascript');
	}

	widget_kbcountdown_register();
}

if ( function_exists('add_action') ){ // just making sure that we're inside of wordpress before doing these next parts.
	// the filter uses the following two functions
	function kbcountdown_filter_callback( $match ){
		global $$match[1];
		return widget_kbcountdown( false, 1, $$match[1], true );
	}
	function kbcountdown_filter($content){
		if ( false === strpos( $content, '^KBCOUNTDOWN||' ) )
			return $content;
		$content = preg_replace_callback( '/\^KBCOUNTDOWN\|\|(.*)\$/U', 'kbcountdown_filter_callback', $content );
		return $content;
	}
	add_action('widgets_init', 'widget_kbcountdown_init');
	add_filter('the_content', 'kbcountdown_filter');
}

// must be outside of the widget_kbcountdown_init() function for legacy support. Pre-3.0 of this widget allowed users to call this function to display countdowns in theme.
// don't do it that way anymore. But for legacy support, here goes:
function widget_kbcountdown($args=false, $number=1, $data=false, $return=false){
	if (is_array($data)){ // user is overriding widget
		$kbcountdown = new kbcountdown();
		return $kbcountdown->widget($args,$data,$return);
	}else{ // probably a routine request from wp for a sidebar widget
		$kbcountdown = new kbcountdown();
		$kbcountdown->widget($args,$number);
	}
}

?>