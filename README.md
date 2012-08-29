#Model Factory (BETA)
An EE2 addon that helps to make working with models in custom addons a little nicer.


##Example Usage

###Define your model

	//make sure we have the Model_factory_base loaded
	if (!class_exists('Model_factory_base')) require PATH_THIRD . 'model_factory/models/model_factory_base.php';

	class Promotion extends Model_factory_base 
	{
	    protected $table_name = 'promotions';
	    
	    protected $primary_key = 'promotion_id';
	    
	    protected $db_cols = array(
	        'promotion_id'      => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE),
	        'title'             => array('type' => 'varchar', 'constraint' => '255'),
	        'entry_id'          => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE),
	    );

	    protected $db_keys = array('entry_id');
	    
	}

###Use the model

	$this->EE->load->model('Promotion', 'promotion');

	$promotion = $this->EE->promotion->get(1);

	$promotions = $this->EE->promotion->get_all();

	$promotion_id = $this->EE->promotion->create($promotion_data);

	$this->EE->promotion->update($promotion_id, $promotion_data);

	$promotion_id = $this->EE->promotion->save(array(
			'title' => 'Promo 1',
	));

	$was_saved = $this->EE->promotion->save(array(
			'promotion_id' => 1,
			'title' => 'Promo 1 [updated]',
	));


###Make sure that you can access the addon's library

	$model_factory_path = PATH_THIRD . '/model_factory';
	if ( ! in_array($model_factory_path, $this->EE->load->get_package_paths()))
	{
		$this->EE->load->add_package_path($model_factory_path);	
	}

###Install models

	$model_factory_path = PATH_THIRD . 'model_factory/';
	if ( ! in_array($model_factory_path, $this->EE->load->get_package_paths()))
	{
		$this->EE->load->add_package_path($model_factory_path);	
	}	

	$this->EE->load->library('Model_factory', null, 'model_factory');

	$this->EE->model_factory->install(array(
		'Promotion',
	));		

###Uninstall models

	$model_factory_path = PATH_THIRD . 'model_factory/';
	if ( ! in_array($model_factory_path, $this->EE->load->get_package_paths()))
	{
		$this->EE->load->add_package_path($model_factory_path);	
	}	

	$this->EE->load->library('Model_factory', null, 'model_factory');

	$this->EE->model_factory->uninstall(array(
		'Promotion',
	));


##More to come... (not currently supported)


	class Event extends Model_factory_channel {

		protected $channel_id = 1;

	}

	$this->EE->load->model('Event', 'events');

	$events = $this->EE->events->get_all();

	foreach($events as $event)
	{
		//access data via the field short name
		echo $event['event_description'];
	}

	$entry_id = $this->EE->events->save(array(
		'title' 				=> 'My New Event Entry',
		'status'				=> 'closed',
		'event_description'	 	=> 'Lorem ipsum ...',
	));

	$this->EE->events->save(array(
		'entry_id'		=> $entry_id,
		'title' 		=> 'My New Event Entry [updated]',
	));







