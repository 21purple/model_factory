<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_factory {


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function __construct()
	{
		$this->EE = get_instance();
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function install($model_names)
	{
		foreach ($model_names as $model_name) 
		{
			if (!isset($this->EE->$model_name))
			{
				$this->EE->load->model($model_name);
			}

			$this->install_model($this->EE->$model_name);	
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function install_model($model)
	{
		$this->EE->load->dbforge();

		$table_name = $model->table_name();

		if ( ! $this->EE->db->table_exists($table_name))
        {
            $this->EE->dbforge->add_field($model->db_cols());

            $primary_key = $model->primary_key();

            if ($primary_key)
            {
            	$this->EE->dbforge->add_key($primary_key, TRUE);	
            }

            foreach ($model->db_keys() as $key) 
            {
            	$this->EE->dbforge->add_key($key);
            }
                     
            $this->EE->dbforge->create_table($table_name);
        }
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function uninstall($model_names)
	{
		foreach ($model_names as $model_name) 
		{
			if (!isset($this->EE->$model_name))
			{
				$this->EE->load->model($model_name);
			}

			$this->uninstall_model($this->EE->$model_name);	
		}
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function uninstall_model($model)
	{
		$this->EE->load->dbforge();

		$table_name = $model->table_name();

		if ($this->EE->db->table_exists($table_name))
        {
            $this->EE->dbforge->drop_table($table_name);
        }		
	}


}