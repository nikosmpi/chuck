<?php
class Chuck {
	public static function greeklish($text) {
		$expressions = array(
			'/[αΑ][ιίΙΊ]/u' => 'ai',
			'/[οΟ][ιίΙΊ]/u' => 'oi',
			'/[Εε][ιίΙΊ]/u' => 'ei',
			'/[αΑ][υύΥΎ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'ay$1',
			'/[αΑ][υύΥΎ]/u' => 'ay',
			'/[εΕ][υύΥΎ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'ey$1',
			'/[εΕ][υύΥΎ]/u' => 'ey',
			'/[οΟ][υύΥΎ]/u' => 'ou',
			'/[νΝ][τΤ]/u' => 'nt',
			'/[τΤ][σΣ]/u' => 'ts',
			'/[τΤ][ζΖ]/u' => 'tz',
			'/[γΓ][γΓ]/u' => 'gg',
			'/[γΓ][κΚ]/u' => 'gk',
			'/[ηΗ][υΥ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'if$1',
			'/[ηΗ][υΥ]/u' => 'iu',
			'/[θΘ]/u' => 'th',
			'/[ψΨ]/u' => 'ps',
			'/[ξΞ]/u' => 'ks',
			'/[αάΑΆ]/u' => 'a',
			'/[βΒ]/u' => 'v',
			'/[γΓ]/u' => 'g',
			'/[δΔ]/u' => 'd',
			'/[εέΕΈ]/u' => 'e',
			'/[€]/u' => ' ',
			'/[ζΖ]/u' => 'z',
			'/[ηήΗΉ]/u' => 'i',
			'/[ιίϊΐΙΊΪ]/u' => 'i',
			'/[κΚ]/u' => 'k',
			'/[λΛ]/u' => 'l',
			'/[μΜ]/u' => 'm',
			'/[νΝ]/u' => 'n',
			'/[οόΟΌ]/u' => 'o',
			'/[πΠ]/u' => 'p',
			'/[ρΡ]/u' => 'r',
			'/[σςΣ]/u' => 's',
			'/[τΤ]/u' => 't',
			'/[υύϋΥΎΫ]/u' => 'y',
			'/[φΦ]/iu' => 'f',
			'/[χΧ]/u' => 'x',
			'/[ωώ]/iu' => 'o',
		);
		return preg_replace(array_keys($expressions), array_values($expressions), $text);
	}
	public static function get_svg($filename){
		ob_start();
		locate_template("assets/svg/$filename.svg", true, false);
		return ob_get_clean();
	}
	public static function svg($filename){
		echo self::get_svg($filename);
	}
	public static function get_esc_email($email) {
		$sanitized_email = sanitize_email($email);
		return is_email($sanitized_email) ? esc_attr($sanitized_email) : '';
	}
	public static function esc_email($email) {
		echo self::get_esc_email($email);
	}
	public static function get_esc_tel($tel) {
		return esc_attr(preg_replace('/[^+0-9]/i', '', $tel));
	}
	public static function esc_tel($tel) {
		echo self::get_esc_tel($tel);
	}
	public static function get_upper($text, $capitalize = false) {
		$text = mb_convert_case((string) $text, $capitalize ?  MB_CASE_TITLE : MB_CASE_UPPER, "UTF-8");
		$replacements = array(
			array('Ά', 'Α'),
			array('Έ', 'Ε'),
			array('Ί', 'Ι'),
			array('Ύ', 'Υ'),
			array('Ό', 'Ο'),
			array(' Ή ', ' -GR_OR- '),
			array('Ή', 'Η'),
			array(' -GR_OR- ', ' Ή '),
			array('Ώ', 'Ω')
		);
		foreach ($replacements as $char) {
			$accented = $char[0];
			$unaccented = $char[1];
			$text = str_replace($accented, $unaccented, $text);
		}
		
		return str_replace('ROĒ', 'roē', $text);
	}
	public static function upper($text, $capitalize = false) {
		echo self::get_upper($text, $capitalize);
	}
	public static function get_sc_element($tag = 'img', $attrs = array()) {
		$html = "<$tag";
		foreach ((array) $attrs as $attr => $value) {
			$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
			$html .= " $attr=\"$value\"";
		}
		$html .= '>';
		return $html;
	}
	public static function sc_element($tag = 'img', $attrs = array()) {
		echo self::get_sc_element($tag, $attrs);
	}
	public static function get_element($tag = 'div', $attrs = array(), $content = '') {
		$html = self::get_sc_element($tag, $attrs);
		$html .= $content;
		$html .= "</$tag>";
		return $html;
	}
	public static function get_src($image, $size = 'full') {
		if ($src = wp_get_attachment_image_src($image, $size, false)) {
			return $src[0];
		}
		return false;
	}
	public static function element($tag = 'div', $attrs = array(), $content = '') {
		echo self::get_element($tag, $attrs, $content);
	}
	public static function get_img_alt($image) {
		if(!$image) {
			$image = get_post_thumbnail_id();
		}
		return trim(strip_tags(get_post_meta($image, '_wp_attachment_image_alt', true)));
	}
	public static function img_alt($image) {
		echo self::get_img_alt($image);
	}
	public static function get_lazy($image, $baseSize = 'full', $sizes = array(), $attrs = array()){
		if (!wp_attachment_is_image($image)) {
			return false;
		}
		if (empty($baseSize)) {
			$baseSize = 'full';
		}
		if (empty($sizes)) {
			$sizes = [
				$baseSize => '16384w'
			];
		}
		$img_attrs = array();
		$content   = array();
		$datasrc   = [];
		if ($sizes) {
			foreach ($sizes as $size => $width) {
				$imageUrl = self::get_src($image, $size);
				if ($imageUrl !== false) {
					$datasrc[]    = esc_attr($imageUrl) . ' ' . $width;
				}
			}
		}
		$img_attrs['data-srcset'] = implode(', ', $datasrc);
		$img_attrs['src']         = esc_attr(self::get_src($image, $baseSize));
		$img_attrs['alt']         = self::get_img_alt($image);
		$img_attrs['srcset']      = "data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
		$img_attrs['class']       = "responsively-lazy";

		return self::get_element('img', $img_attrs);
	}
	public static function lazy($image, $baseSize = 'full', $sizes = array(), $attrs = array()){
		echo self::get_lazy($image, $baseSize, $sizes, $attrs);
	}
	public static function get_image($image, $sources = array(), $sizes = array(), $attrs = array()) {
		if (!wp_attachment_is_image($image)) {
			return false;
		}
		$srcset = array();
		foreach ($sources as $size) {
			if ($src = wp_get_attachment_image_src($image, $size, false)) {
				$srcset[] = "{$src[0]} {$src[1]}w {$src[2]}h";
			}
		}
		if (empty($srcset)) {
			return false;
		}
		$img_attrs = array_merge(array(
				'srcset' => implode(', ', $srcset),
				'sizes'  => implode(', ', $sizes),
				'alt'    => self::get_img_alt($image)
		), (array) $attrs);
		return self::get_sc_element('img', $img_attrs);
	}
	public static function image($image, $sources = array('full'), $sizes = array(), $attrs = array()) {
		echo self::get_image($image, $sources, $sizes, $attrs);
	}
	public static function get_bem($block, $sub_classes = array()) {
		return $block . implode(" $block", (array) $sub_classes);
	}
	public static function bem($block, $sub_classes = array()) {
		echo self::get_bem($block, $sub_classes);
	}
	public static function time_without_seconds($time) {
		$exp_time = explode(':', $time);
		if(count($exp_time) > 1) {
			return $exp_time[0] . ":" . $exp_time[1];
		}
		return $time;
	}
	public static function date_greek($format, $time = null) {
		if ($time === null) $time = time();
		$date = date($format, $time);
		if (strpos($format, 'F') !== false) {
			$en_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$el_months = array('Ιανουαρίου', 'Φεβρουαρίου', 'Μαρτίου', 'Απριλίου', 'Μαΐου', 'Ιουνίου', 'Ιουλίου', 'Αυγούστου', 'Σεπτεμβρίου', 'Οκτωβρίου', 'Νοεμβρίου', 'Δεκεμβρίου');
		} else {
			$en_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
			$el_months = array('Ιαν', 'Φεβ', 'Μαρ', 'Απρ', 'Μαι', 'Ιουν', 'Ιουλ', 'Αυγ', 'Σεπ', 'Οκτ', 'Νοε', 'Δεκ');
		}

		$en_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$el_days = array('Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο', 'Κυριακή');
		$en_days_s = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
		$el_days_s = array('Δευ', 'Τρι', 'Τετ', 'Πεμ', 'Παρ', 'Σαβ', 'Κυρ');
		$en_ampm = array('AM', 'PM');
		$el_ampm = array('ΠΜ', 'ΜΜ');

		$date_el = str_replace($en_months, $el_months, $date);
		$date_el = str_replace($en_days, $el_days, $date_el);
		$date_el = str_replace($en_days_s, $el_days_s, $date_el);
		$date_el = str_replace($en_ampm, $el_ampm, $date_el);

		return $date_el;
	}
	public static function integer_to_roman($integer) {
		$integer = intval($integer);
		$result = '';
		$lookup = array(
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1
		);
		foreach ($lookup as $roman => $value) {
			$matches = intval($integer / $value);
			$result .= str_repeat($roman, $matches);
			$integer = $integer % $value;
		}
		return $result;
	}

	public static function greek_month($m) {
		$month_array = array(
			'Ιανουαρίου',
			'Φεβρουαρίου',
			'Μαρτίου',
			'Απριλίου',
			'Μαΐου',
			'Ιουνίου',
			'Ιουλίου',
			'Αυγούστου',
			'Σεπτεμβρίου',
			'Οκτωβρίου',
			'Νοεμβρίου',
			'Δεκεμβρίου',
		);
		return $month_array[$m];
	}
	public static function greek_day($d) {
		$day_array = array(
			'Δευτέρα      ',
			'Τρίτη',
			'Τετάρτη',
			'Πέμπτη',
			'Παρασκευή',
			'Σάββατο',
			'Κυριακή',
		);
		return $day_array[$d];
	}
	public static function greek_date($date) {
		$dd = Chuck::greek_day(date('N', strtotime($date)) - 1);
		$d = date('j', strtotime($date));
		$m = Chuck::greek_month(date('n', strtotime($date)) - 1);
		$y = date('Y', strtotime($date));
		return "$dd $d $m $y";
	}
	public static function time($time) {
		$time_ex = explode(':', $time);
		if(is_array($time_ex) && isset($time_ex[0]) && isset($time_ex[1])) {
			return $time_ex[0] . ":" . $time_ex[1];
		}
		return $time;
	}
}