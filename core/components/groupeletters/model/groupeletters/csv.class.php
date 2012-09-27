<?php
	###################
	#	Date: 4/21/08
	#	Author: Joshua Gullege
	#	Name: csv
	#	This file will make a export file to CSV (Comma-separeted values - open in Excel) file
	# -> http://www.creativyst.com/Doc/Articles/CSV/CSV01.htm
	###################
	//set_time_limit(300); 
	//max_execution_time(100);
/**
 * @desciption Make CSV files and/or import them
 */
class CSV {
    /**
     * @param (Array) $columns - the names of the columns/headers in name=>Display-Name format
     * 
     */
	protected $columns = array();
    /**
     * @param (Array) $data - the csv data array(name=>value);
     * 
     */
    protected $data = array();
    
    /**
     * @param (Boolean) $bind
     */
	protected $bind = false;
    
    
    
    /**
     * 
     */
	protected $import_columns = 0;
	protected $import_rows = 0;
    public $padd_cell = false;//true;
    
	/**
     * 
     */
	public function __construct(){
		
	}
    /**
     * @param (Array) $column_names - the names of the columns/headers in name=>Display-Name format
     * @param (Boolean) $bind - bind column names to rows
     * @param (Boolean) $make_header - make the first row the header row
     * @return Void 
     */
    public function setColumns($columns, $bind=true, $make_header=true) {
        $this->bind = $bind;
        // make the column header names
		foreach ( $columns as $name => $value ) {
			if ( $value == NULL ) {
				continue;
			}
			$this->columns[$name] = $value;
		}
        if ( $make_header ) {
            $this->setRow($columns);
        }
    }
    
    /**
     * Set a row in the CSV data
     * @param (Array) $row - (name=>Value, name=>Value)  
     *       The name is the column and must match to a name in the this->column_names
     * @return VOID  
     */
    public function setRow( $row ){
        $this->data[] = $row;
    }
    /**
     * Build the CSV string
     * @param (Array) $rowData - Optional fill in custom data array(name=>Value, name=>Value)
     * @return (String) $csv - the built CSV string  
     */
	public function build( $rowData=NULL ){
		$csv = NULL;
        $data = $this->data;
        if ( !empty($rowData)  & is_array($rowData) ) {
            $data = $rowData;
        }
		foreach ( $data as $count => $row ) {
    		if ( !empty($csv) ) {
    		  $csv .= "\r";// this should be \n\r ??
            }
    		$strip_comma = false;
    		if ( $this->bind ) {
    			// bind to the column names
    			foreach ( $this->column_names as $name => $value ) {
    				$str = $row[$name];
    				$csv .= $this->escapeCSV((string) $str).",";
    				$strip_comma = true;
    			}
    		} else {
    			foreach ($row as $name => $value ) {
    				$csv .= $this->escapeCSV((string) $value).",";
    				$strip_comma = true;
    			}
    		}
    		if ( $strip_comma ) {
    			$csv = substr($csv, 0, (strlen($csv) - 1) );
    		}
        }
		return $csv;
	}
    /**
     * Sends headers to download the created CSV and then the CSV data
     * @param (string) $filename - the name of the file
     * @return Void
     */
	public function download($name){
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=".$name.".csv");
		header("Pragma: no-cache");
		header("Expires: 0"); echo $this->build();
		
		return;
	}
    /**
     * Write the CSV data to a file
     * @param (String) $file_path - the full file path and name
     * @return (Boolean)  
     */
	public function toFile($file){
		// remove the .csv if present, this allows to send a file name with no extension 
		$pos = strripos($file, '.csv');
		if( $pos > 0 && strlen($file) - 4 == $pos ){  
			$file = substr($file,0, $pos );
		}
		if(file_put_contents($file.'.csv', $this->build() ) ){
			// unset the data
			return true;
		}
		return false;
	}
	/**
     * Escape possible errors
     * @access protected
     * @param (string) $str
     * @return (String) $str
     */
	protected function escapeCSV($str){
		// if it has a double quote or a new line it must be double quoted
		if(preg_match("/[,\"\n\r]/", $str) > 0) {
			$str = str_replace('"', '""', $str);
		}
        if ( $this->padd_cell ) {
            return '" '.$str.' "';
        } else {
            return '"'.$str.'"';
        }
	}
	
	####################################################################################
	/**
     * Import CSV data
     * @param (String) $file - the full file path and name
     * @param (Int) $length
     * @param (String) $delimiter
     * @param (String) $enclosure
     * @return (Array) $data - the imported data
     */
	public function import($file, $length=1024, $delimiter=",", $enclosure='"'){
		# from this page: http://us.php.net/fgetcsv
		# Example #1 Read and print the entire contents of a CSV file
		$row_number = 0;
		$this->import_columns = 0;
		$this->import_rows = 0;
        // get the header for the first row
		if( $handle = fopen($file, "r") ){
			//echo '<br>CSV GET';
			$this->columns = array();
            $colOrder = array();
            $count = 0;
			while( ($row = fgetcsv($handle, $length, $delimiter, $enclosure)) !== FALSE) {
				if( count($row) > $this->import_columns ){
					$this->import_columns = count($row);
				}
			    $tmp = array();
		        foreach ( $row as $i => $value ) {
		            if ( $count == 0 ) {
			            $this->columns[$value] = $value;
                        $colOrder[$i] = $value;
			        } else {
			            $tmp[$colOrder[$i]] = $value;
			        }
			    }
				if ( $count > 0 ) {
				    $this->data[$row_number++] = $tmp;
                }
				++$count;
			}
			$this->import_rows = --$row_number;
			fclose($handle);
		}
		return $this->data;
	}
    /**
     * Import Fixed lenght file
     * @param (String) $file - the full file path and name
     * @param (Array) $fixed - the length of each column ex: array( 15, 30, 30...)
     * @param (Int) $length
     * @return (Array) $data - the imported data
     */
	public function importFixed($file, $fixed=array(), $length=4096){
		# from this page: http://us.php.net/fgetcsv
		# Example #1 Read and print the entire contents of a CSV file
		$row_number = 0;
		$this->import_columns = 0;
		$this->import_rows = 0;
		$line_len = 0;
		foreach ( $fixed as $len ) {
			$line_len += $len;
		}
		if ( $handle = fopen($file, "r") ){
			//echo '<br>CSV GET';
			while ( !feof($handle) ) { //( ($row = fgetcsv($handle, $length, $delimiter, $enclosure)) !== FALSE) {
				$line = fgets($handle, $length);
				if ( $line_len < strlen($line) || $line_len == 0 ) {
					continue; // invalid row
				}
				// now make the line into an array row 
				$s = $c = 0;
				$row = array(); // array( 0 => value, ...
				foreach ( $fixed as $len ) {
					$row[$c++] = substr($line, $s, $len );
					$s += $len; 
				}
				if( count($row) > $this->import_columns ){
					$this->import_columns = count($row);
				}
				$this->data[$row_number++] = $row;
				/*if( $row_number > 100 ){
					break;
				}*/
			}
			$this->import_rows = --$row_number;
			fclose($handle);
		}
		return $this->data;
	}
	
	/**
     * Make CSV data into a html table
     * @param (String) $header - any html to put as a table header
     * @param (String) $attributes 
     * @param (Boolean) $number - show row numbers
     */
	public function toTable($header=NULL, $attributes='class="CSV_table"', $number=true ){
		$str = '
		<table '.$attributes.'>';
		if( $header != NULL ){
			$str .= $header;
		}
		# create rows
		for( $x = 0; $x < $this->import_rows; $x++ ){
			$str .= '
			<tr>';
			if ( $number ) {
				$str .= '
				<td>'.($x + 1).'</td>';
			}
			# create columns
			$row = $this->data[$x];
			for( $y = 0; $y < $this->import_columns; $y++ ){
				$str .= '
				<td>'.$row[$y].'</td>';
			}
			$str .= '
			</tr>';
		}
		$str .= '
		</table>';
		return $str;
	}
}

