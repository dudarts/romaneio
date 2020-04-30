<?php
	$handle = printer_open("\\\\192.168.0.10\\Bematech_LB-1000");
	printer_set_option($handle, PRINTER_MODE, "RAW");
	printer_write($handle,file_get_contents("etiqueta.prn"));
	printer_close($handle);
?>