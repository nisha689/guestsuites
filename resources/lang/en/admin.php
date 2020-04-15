<?php
return [
	'user' => [
		'title' => 'Users',
		'title_single' => 'User',
		'fields' => [
			'id'=>'ID#',
			'first_name'=>'First Name',
			'last_name'=>'Last Name',
			'phone'=>'Phone',
			'email' => 'Email',
			'password' => 'Password',
			'remember-token' => 'Remember token',
			'name' => 'Names',
			'principal' => 'Principal',
			'joined' => 'Joined',
			'classes' => 'Classes',
			'status' => 'Status',
			'action' => 'Action',
		],
	],
    'school' => [
        'title' => 'Schools',
        'title_single' => 'School',
        'fields' => [
            'id'=>'ID#',
            'name'=>'Name',
            'phone'=>'Phone',
            'email'=>'Email',
        ],
    ],
    'teacher' => [
        'title' => 'Teachers',
        'title_single' => 'Teacher',
        'fields' => [
            'id'=>'ID#',
            'name'=>'Name',
            'phone'=>'Phone',
            'email'=>'Email',
            'class'=>'Class',
            'school'=>'School',
        ],
    ],
    'classes' => [
        'title' => 'Classes',
        'title_single' => 'Classes',
        'fields' => [
            'id'=>'ID#',
            'class_name'=>'Class Name',
            'school_id'=>'School',
        ],
    ],
    'student' => [
        'title' => 'Students',
        'title_single' => 'Student',
        'fields' => [
            'id'=>'ID#',
            'name'=>'Name',
            'phone'=>'Phone',
            'email'=>'Email',
            'school'=>'School',
            'class'=>'Class',
        ],
    ],
    'parent' => [
        'title' => 'Parents',
        'title_single' => 'Parent',
        'fields' => [
            'id'=>'ID#',
            'name'=>'Name',
            'phone'=>'Phone',
            'email'=>'Email',
        ],
    ],
    'backend_log' => [
        'title' => 'Backend logs',
        'title_single' => 'Backend Log',
        'fields' => [
            'id'=>'ID#',
            'name'=>'Name',
            'email'=>'Email',
            'date_time'=>'Date/Time',
            'ip_address'=>'IP',
        ],
    ],
    'qa_action' => 'Action',
	'qa_created_date'=>'Created Date',
	'qa_updated_date'=>'Updated Date',
	'qa_create' => 'Create',
	'qa_save' => 'Save',
	'qa_edit' => 'Edit',
	'qa_all' => 'All',
	'qa_trash' => 'Trash',
	'qa_view' => 'View',
	'qa_update' => 'Update',
	'qa_list' => 'List',
	'qa_no_entries_in_table' => 'Zero records found.',
	'qa_logout' => 'Logout',
	'qa_add_new' => 'Add New',
	'qa_are_you_sure' => 'Are you sure?',
	'qa_back_to_list' => 'Back',
	'qa_dashboard' => 'Dashboard',
	'qa_delete' => 'Delete',
	'qa_ban_user' => 'Ban User',
	'qa_reactive_user' => 'Reactivate User',
	'qa_delete_selected' => 'Delete selected',
	'qa_users' => 'Users',
	'qa_user' => 'User',
	'qa_name' => 'Name',
	'qa_email' => 'Email',
	'qa_password' => 'Password',
	'qa_remember_token' => 'Remember token',
	'qa_permissions' => 'Permissions',
	'qa_user_actions' => 'User actions',
	'qa_action_model' => 'Action model',
	'qa_action_id' => 'Action id',

	'qa_photo1' => 'Photo1',
	'qa_photo2' => 'Photo2',
	'qa_photo3' => 'Photo3',
	'qa_calendar' => 'Calendar',
	'qa_statuses' => 'Statuses',
	'qa_task_management' => 'Task management',
	'qa_tasks' => 'Tasks',
	'qa_status' => 'Status',
	'qa_attachment' => 'Attachment',
	'qa_due_date' => 'Due date',
	'qa_assigned_to' => 'Assigned to',
	'qa_assets' => 'Assets',
	'qa_asset' => 'Asset',
	'qa_serial_number' => 'Serial number',
	'qa_location' => 'Location',
	'qa_locations' => 'Locations',
	'qa_assigned_user' => 'Assigned (user)',
	'qa_notes' => 'Notes',
	'qa_assets_history' => 'Assets history',
	'qa_assets_management' => 'Assets management',
	'qa_slug' => 'Slug',
	'qa_content_management' => 'Content management',
	'qa_text' => 'Text',
	'qa_excerpt' => 'Excerpt',
	'qa_featured_image' => 'Featured image',
	'qa_pages' => 'Pages',
	'qa_axis' => 'Axis',
	'qa_show' => 'Show',
	'qa_group_by' => 'Group by',
	'qa_chart_type' => 'Chart type',
	'qa_create_new_report' => 'Create new report',
	'qa_no_reports_yet' => 'No reports yet.',
	'qa_created_at' => 'Created at',
	'qa_updated_at' => 'Updated at',
	'qa_deleted_at' => 'Deleted at',
	'qa_reports_x_axis_field' => 'X-axis - please choose one of date/time fields',
	'qa_reports_y_axis_field' => 'Y-axis - please choose one of number fields',
	'qa_select_crud_placeholder' => 'Please select one of your CRUDs',
	'qa_select_dt_placeholder' => 'Please select one of date/time fields',
	'qa_aggregate_function_use' => 'Aggregate function to use',
	'qa_x_axis_group_by' => 'X-axis group by',
	'qa_x_axis_field' => 'X-axis field (date/time)',
	'qa_y_axis_field' => 'Y-axis field',
	'qa_integer_float_placeholder' => 'Please select one of integer/float fields',
	'qa_change_notifications_field_1_label' => 'Send email notification to User',
	'qa_change_notifications_field_2_label' => 'When Entry on CRUD',
	'qa_select_users_placeholder' => 'Please select one of your Users',
	'qa_is_created' => 'is created',
	'qa_is_updated' => 'is updated',
	'qa_is_deleted' => 'is deleted',
	'qa_notifications' => 'Notifications',
	'qa_notify_user' => 'Notify User',
	'qa_when_crud' => 'When CRUD',
	'qa_create_new_notification' => 'Create new Notification',
	'qa_stripe_transactions' => 'Stripe Transactions',
	'qa_upgrade_to_premium' => 'Upgrade to Premium',
	'qa_messages' => 'Messages',
	'qa_you_have_no_messages' => 'You have no messages.',
	'qa_all_messages' => 'All Messages',
	'qa_new_message' => 'New message',
	'qa_outbox' => 'Outbox',
	'qa_inbox' => 'Inbox',
	'qa_recipient' => 'Recipient',
	'qa_subject' => 'Subject',
	'qa_message' => 'Message',
	'qa_send' => 'Send',
	'qa_reply' => 'Reply',
	'qa_calendar_sources' => 'Calendar sources',
	'qa_new_calendar_source' => 'Create new calendar source',
	'qa_crud_title' => 'Crud title',
	'qa_crud_date_field' => 'Crud date field',
	'qa_prefix' => 'Prefix',
	'qa_label_field' => 'Label field',
	'qa_suffix' => 'Sufix',
	'qa_no_calendar_sources' => 'No calendar sources yet.',
	'qa_crud_event_field' => 'Event label field',
	'qa_create_new_calendar_source' => 'Create new Calendar Source',
	'qa_edit_calendar_source' => 'Edit Calendar Source',
	'qa_client_management' => 'Client management',
	'qa_client_management_settings' => 'Client management settings',
	'qa_country' => 'Country',
	'qa_client_status' => 'Client status',
	'qa_clients' => 'Clients',
	'qa_client_statuses' => 'Client statuses',
	'qa_currencies' => 'Currencies',
	'qa_main_currency' => 'Main currency',
	'qa_documents' => 'Documents',
	'qa_file' => 'File',
	'qa_income_source' => 'Income source',
	'qa_income_sources' => 'Income sources',
	'qa_fee_percent' => 'Fee percent',
	'qa_note_text' => 'Note text',
	'qa_client' => 'Client',
	'qa_start_date' => 'Start date',
	'qa_budget' => 'Budget',
	'qa_project_status' => 'Project status',
	'qa_project_statuses' => 'Project statuses',
	'qa_transactions' => 'Transactions',
	'qa_transaction_types' => 'Transaction types',
	'qa_transaction_type' => 'Transaction type',
	'qa_transaction_date' => 'Transaction date',
	'qa_currency' => 'Currency',
	'qa_current_password' => 'Current Password',
	'qa_new_password' => 'New Password',
	'qa_password_confirm' => 'New Password Confirmation',
	'qa_dashboard_text' => 'You are logged in!',
	'qa_forgot_password' => 'Forgot your password?',
	'qa_remember_me' => 'Remember me',
	'qa_login' => 'Login',
	'qa_go_back_to_login' => 'Back to Login',
	'qa_change_password' => 'Change password',
	'qa_csv' => 'CSV',
	'qa_print' => 'Print',
	'qa_excel' => 'Excel',
	'qa_copy' => 'Copy',
	'qa_colvis' => 'Column visibility',
	'qa_pdf' => 'PDF',
	'qa_reset_password' => 'Reset password',
	'qa_reset_password_woops' => '<strong>Whoops!</strong> There were problems with input:',
	'qa_email_line1' => 'You are receiving this email because we received a password reset request for your account.',
	'qa_email_line2' => 'If you did not request a password reset, no further action is required.',
	'qa_email_greet' => 'Hello',
	'qa_email_regards' => 'Regards',
	'qa_confirm_password' => 'Confirm password',
	'qa_if_you_are_having_trouble' => 'If you’re having trouble clicking the',
	'qa_copy_paste_url_bellow' => 'button, copy and paste the URL below into your web browser:',
	'qa_please_select' => 'Please select',
	'qa_register' => 'Register',
	'qa_registration' => 'Registration',
	'qa_submit' => 'Submit',
	'qa_not_approved_title' => 'You are not approved',
	'qa_not_approved_p' => 'Your account is still not approved by administrator. Please, be patient and try again later.',
	'qa_there_were_problems_with_input' => 'There were problems with input',
	'qa_whoops' => 'Whoops!',
	'qa_file_contains_header_row' => 'File contains header row?',
	'qa_csvImport' => 'CSV Import',
	'qa_csv_file_to_import' => 'CSV file to import',
	'qa_parse_csv' => 'Parse CSV',
	'qa_import_data' => 'Import data',
	'qa_imported_rows_to_table' => 'Imported :rows rows to :table table',
	'admin_title' => 'Guest Suites',
    'admin_send_password_reset_link' => 'Send Password Reset Link',
    'next'=>'Next',
	'previous'=>'Previous',
	'cancel'=>'Cancel',
	'qa_none'=>'NONE',
	'qa_send_email'=>'Send Mail',
	'btn_get_google_longitude_latitude'=>'Get Longitude And Latitude From Google',
	'qa_select'=>'-- select --',
	'front_title' => 'Guest Suites',
	'qa_search' => 'Search',
	'qa_softball_connected_home' => 'SoftballConnected Homepage',
	'qa_my_modules' => 'My Home Page',
	'qa_pudate_profile' => 'Update Profile',
	'qa_city_custom_error_msg' => 'Please first select state.',
	'btn_generate_url_key' => 'Generate Url Key',
	'btn_add_more' => 'Add More',
	'btn_remove' => 'Remove',
    'qa_duplicate' => 'Duplicate',
    'qa_show_banners' => 'Show Banners',
    'qa_show_banner_tracking' => 'Show Banner Trackings',
    'google_captcha' => 'Captcha',
    'email' => 'Email',
    'btn_import' => 'Import CSV',
    'import_csv' => 'Import CSV',
    'csv_view_import_result' => 'View Import Result',
    'csv_download_result_file' => 'Download Result File',
    'go_to' => 'Go to',
    'btn_approved' => 'Approved',
    'btn_pending' => 'Pending',
    'btn_rejected' => 'Rejected',
    'btn_remove_attachment' => 'Remove Attachment',
    'qa_invite' => 'Invite',
    'qa_are_you_sure_ban_user' => 'Are you sure you want to ban this user?',
    'qa_are_you_sure_reactive_user' => 'Are you sure you want to reactivate this user?',
    'qa_are_you_sure_delete' => 'Are you sure you want to delete this',
    'qa_are_you_sure_delete_user' => 'Are you sure you want to delete this user?',
    'qa_are_you_sure_delete_school' => 'Are you sure you want to delete this school?',
    'qa_are_you_sure_delete_class' => 'Are you sure you want to delete this class?',
    'qa_are_you_sure_delete_teacher' => 'Are you sure you want to delete this teacher?',
    'qa_are_you_sure_delete_student' => 'Are you sure you want to delete this student?',
    'qa_are_you_sure_delete_parent' => 'Are you sure you want to delete this parent?',
    'qa_delete_user' => 'Delete User',
    'qa_delete_school' => 'Delete Account',
    'qa_send_message' => 'Send Message',
	'qa_ban_school' => 'Ban school',
	'qa_reactive_school' => 'Reactivate school',
	'qa_are_you_sure_ban_school' => 'Are you sure you want to ban this school?',
	'qa_are_you_sure_reactive_school' => 'Are you sure you want to reactivate this school?',
    'qa_are_you_sure_delete_notification' => 'Are you sure you want to delete this notification?',
    'qa_school_not_login_in_app' => 'School admin have to login in app at least once.',
	'qa_export' => 'Export',
    ];
