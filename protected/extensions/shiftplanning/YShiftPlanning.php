<?
/**
 * ShiftPlanning PHP SDK
 * Version: 1.0
 * Date: 11/01/2010
 * http://www.shiftplanning.com/api/
 */

/**
 * Quick Access ShiftPlanning SDK Methods:
 * doLogin( $array_of_user_data )
 * doLogout( )
 * getMessages( )
 * getMessageDetails( $message_id )
 * createMessage( $array_of_message_data )
 * deleteMessage( $message_id )
 * getWallMessages( )
 * createWallMessage( $array_of_message_data )
 * deleteWallMessage( $message_id, $array_of_other_message_data )
 * getEmployees( )
 * getEmployeeDetails( $employee_id_number )
 * updateEmployee( $employee_id, $array_of_updated_employee_data )
 * createEmployee( $array_of_employee_data )
 * deleteEmployee( $employee_id )
 * getStaffSkills( )
 * getStaffSkillDetails( $skill_id )
 * createStaffSkill( $array_of_skill_data )
 * updateStaffSkill( $skill_id, $array_of_skill_data )
 * deleteStaffSkill( $skill_id )
 * createPing( $array_of_ping_data )
 * getSchedules( )
 * getScheduleDetails( $schedule_id )
 * createSchedule( $array_of_schedule_data )
 * updateSchedule( $schedule_id, $array_of_schedule_data )
 * deleteSchedule( $schedule_id )
 * getShifts( )
 * getShiftDetails( $shift_id )
 * updateShift( $shift_id, $array_of_shift_data )
 * createShift( $array_of_shift_data )
 * deleteShift( $shift_id )
 * getVacationSchedules( $time_period_array )	// e.g. getVacationSchedules( array( 'start' => '', 'end' => '' ) );
 * getVacationScheduleDetails( $schedule_id )
 * createVacationSchedule( $array_of_schedule_data )
 * updateVacationSchedule( $schedule_id, $array_of_schedule_data )
 * deleteVacationSchedule( $schedule_id )
 * getScheduleConflicts( )
 * getAdminSettings( )
 * updateAdminSettings( $array_of_new_settings )
 * getAdminFiles( )
 * getAdminFileDetails( $file_id )
 * updateAdminFile( $file_id, $array_of_file_data )
 * createAdminFile( $array_of_file_data )
 * deleteAdminFile( $file_id )
 * getAdminBackups( )
 * getAdminBackupDetails( $backup_id )
 * createAdminBackup( $array_of_backup_data )
 * deleteAdminBackup( $backup_id )
 * getAPIConfig( )
 * getAPIMethods( )
 */

/**
 * All Quick-Access methods return a response like this:
 * array(
 * 	'status' => array( 'code' => '1', 'text' => 'Success', 'error' => 'Error message if any' ),
 * 	'data' => array(
 *		'field_name' => 'value'
 * 		)
 * 	)
 *
 * For methods that return multiple objects (as in the case for the getMessages( ) method
 * responses will look like this, where the indexes [0], [1] would be replaced with the
 * message you're looking to display
 *
 * array(
 * 	'status' => array( 'code' => '1', 'text' => 'Success', 'error' => 'Error message if any' ),
 * 	'data' => array(
 *		[0] => array (
 *				'id' => 1,
 *				'name' => 'value'
 *			)
 *		[1] => array (
 *				'id' => 2,
 *				'name' => 'value'
 *			)
 * 		)
 * 	)
 */
 
require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'ShiftPlanning.php');

class YShiftPlanning extends shiftplanning {
	}