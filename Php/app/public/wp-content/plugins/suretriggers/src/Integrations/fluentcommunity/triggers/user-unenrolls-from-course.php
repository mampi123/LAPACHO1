<?php
/**
 * UserUnenrollsFromCourse.
 * php version 5.6
 *
 * @category UserUnenrollsFromCourse
 * @package  SureTriggers
 * @author   BSF
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://www.brainstormforce.com/
 * @since    1.0.0
 */

namespace SureTriggers\Integrations\FluentCommunity\Triggers;

use SureTriggers\Controllers\AutomationController;
use SureTriggers\Traits\SingletonLoader;

if ( ! class_exists( 'UserUnenrollsFromCourse' ) ) :

	/**
	 * UserUnenrollsFromCourse
	 *
	 * @category UserUnenrollsFromCourse
	 * @package  SureTriggers
	 * @since    1.0.0
	 */
	class UserUnenrollsFromCourse {

		/**
		 * Integration type.
		 *
		 * @var string
		 */
		public $integration = 'FluentCommunity';

		/**
		 * Trigger name.
		 *
		 * @var string
		 */
		public $trigger = 'fc_user_unenrolls_from_course';

		use SingletonLoader;

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_filter( 'sure_trigger_register_trigger', [ $this, 'register' ] );
		}

		/**
		 * Register the trigger.
		 *
		 * @param array $triggers Existing triggers.
		 * @return array
		 */
		public function register( $triggers ) {
			$triggers[ $this->integration ][ $this->trigger ] = [
				'label'         => __( 'User Unenrolls From Course', 'suretriggers' ),
				'action'        => $this->trigger,
				'common_action' => 'fluent_community/course/student_left',
				'function'      => [ $this, 'trigger_listener' ],
				'priority'      => 10,
				'accepted_args' => 3,
			];
			return $triggers;
		}

		/**
		 * Trigger listener.
		 *
		 * @param object $course  The course object.
		 * @param int    $user_id The user ID.
		 * @return void
		 */
		public function trigger_listener( $course, $user_id ) {
			if ( empty( $course ) || empty( $user_id ) ) {
				return;
			}

			$context = [
				'course' => $course,
				'userId' => $user_id,
			];

			AutomationController::sure_trigger_handle_trigger(
				[
					'trigger' => $this->trigger,
					'context' => $context,
				]
			);
		}
	}

	// Initialize the class.
	UserUnenrollsFromCourse::get_instance();

endif;
