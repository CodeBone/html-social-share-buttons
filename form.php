<?php
class zm_form{
	
	public $options;
	
	function __construct($options = ""){
		global $zm_sh_default_options;
		$this->options = $options ? $options : get_option("zm_shbt_fld", $zm_sh_default_options);
	}
	
	function text($id, $label){
		echo "<div class='row'>";
			echo "<label for='$id' style='width:140px;line-height: 37px;'>$label</label>";
			echo "<input type='text' id='$id' name='zm_shbt_fld[$id]' value='{$this->options[$id]}' style='width: 432px;height: 33px;	background-color: #ffffff;border: 1.2px solid #B8B8B8;' >";
		echo "</div>";
	}
	
	
	function checkbox($id, $label, $name = '', $selected=false, $class = 'toggle-check', $yes = "", $no = ""){
		$yes = $yes?$yes:__("Yes", "zm_sh");
		$no = $no?$no:__("No", "zm_sh");
		$chk = $selected===false?checked($this->options[$id], true, false):$selected;
		$name = $name ? $name : "zm_shbt_fld[$id]";
		echo "<div class='row'>";
			echo "<label for='$id'>$label</label>";
			echo "<input name='$name' id='$id' $chk type='checkbox' value='1'/>";
			echo "<span class='for_label'>";
				echo "<label for='$id' class='$class' data-on='$yes' data-off='$no'></label>";
			echo "</span>";
		echo "</div>";
	}
	
	function show_on($id, $label, $selected=false, $class = 'toggle-check', $yes = "", $no = ""){
		$yes	= $yes?$yes:__("Yes", "zm_sh");
		$no		= $no?$no:__("No", "zm_sh");
		$name	= "zm_shbt_fld[show_in][$id]";
		$name_1	= "zm_shbt_fld[$id]";
		$chk	= $this->options['show_in'][$id]?'checked="checked"':'';
		$circle	= $selected===false?checked($this->options[$id], 'circle', false):$selected;
		$square	= $selected===false?checked($this->options[$id], 'square', false):$selected;
		if($chk and !$circle and !$square)
			$circle = 'checked="checked"';
		echo "<div class='row toggle'>";
			echo "<label for='$id'>$label</label>";
			echo "<input id='$id' $chk type='checkbox' name='{$name}' value='1'/>";
			echo "<span class='for_label'>";
				echo "<label for='$id' class='$class' data-on='$yes' data-off='$no'></label>";
				
				echo "<div class='row show_on' style='margin-top:50px'>";
					echo "<input type='radio' id='$id-circle' name='$name_1' value='circle' $circle >";
					echo "<label for='$id-circle'><img src='". zm_sh_url_assets_img . $id . "-circle.png'></label>";
					
					echo "<input type='radio' id='$id-square' name='$name_1' value='square' $square >";
					echo "<label for='$id-square'><img src='". zm_sh_url_assets_img . $id . "-square.png'></label>";
				echo "</div>";
			echo "</span>";
			
		echo "</div>";
	}
	
	function icon_fields($label, $label_prefix, $class = 'toggle-check', $yes = "", $no = ""){
		$icons = zm_sh_get_icons($this->options['iconset']);
		echo "<div class='row' style='margin-bottom:20px'>";
			echo "<h2>$label</h2>";
		echo "</div>";
		foreach($icons as $name=>$id){
			$chk = checked($this->options['icons'][$id], true, false);
			$this->checkbox('icon_'.$id, $label_prefix.' '.$name, "zm_shbt_fld[icons][$id]", $chk, $class, $yes, $no);
		}
	}
	
	function dropdown($id, $label, $items, $name=false, $selected=false){
		$name = $name ? $name : "zm_shbt_fld[$id]";
		echo "<div class='row'>";
			echo "<label for='$id'>$label</label>";
			echo "<select id='$id' name='$name'>";
			foreach($items as $i_id=>$i_name){
				$selected = selected($this->options[$id], $i_id, false);
				echo "<option value='{$i_id}' $selected>{$i_name}</option>";
			}
			echo "</select>";
		echo "</div>";
	}
	
	function select_iconset($id, $label){
		$iconsets = zm_sh_get_iconset_list();
		$this->dropdown($id, $label, $iconsets);
	}
	
	function fld_dropdown($id){
		global $zm_sh_in_widget;
		$iconsets = zm_sh_get_iconsets();
		
		if($zm_sh_in_widget){
			$obj = $zm_sh_in_widget['obj'];
			$instance = $zm_sh_in_widget['intstance'];
			$curr_iconset = $instance[$id];
			if($curr_iconset == "")
				$curr_iconset = 'default';
			
			$uid = $obj->get_field_id($id);
			$name = $obj->get_field_name($id);
			
			echo "<select id='".$uid."' name='$name'>";
			
			$iconset_default = $iconsets['default'];
			unset( $iconsets['default']);
			$iconsets = array_merge( array('default' => $iconset_default), $iconsets);
			
			foreach($iconsets as $iconset){
				$selected = "";
				if($iconset['id'] == $curr_iconset)
					$selected = "selected";
				echo "<option value='{$iconset['id']}' $selected>{$iconset['name']}</option>";
			}
			echo "</select>";
		}
	}
	
	
}