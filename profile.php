<?php

session_start();
include("includes/DB.php");
$pdo = DB();
include("includes/html_codes.php");
if(!isset($_SESSION['user_id']) ){
	header('Location:login.php');
}

$error = array();

$default_day_check = query($pdo, " SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
if( count($default_day_check) == 1 ){
	$default_day = $default_day_check[0]['birth_day'];
}else{
	$default_day = '';
}

$default_month_check = query($pdo, " SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
if( count($default_month_check) == 1 ){
	$default_month = $default_month_check[0]['birth_month'];
}else{
	$default_month = '';
}

$default_year_check = query($pdo, " SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
if(count($default_year_check)==1){
	$default_year = $default_year_check[0]['birth_year'];
}else{
	$default_year = '';
}

$default_country_check = query($pdo, " SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
if( count($default_country_check) == 1 ){
	$default_country = $default_country_check[0]['country'];
}else{
	$default_country = '';
}

$default_city_check = query($pdo, " SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
if( count($default_city_check) == 1 ){
	$default_city = $default_city_check[0]['city'];
}else{
	$default_city = '';
}

if(isset($_POST['profile_submit'])){
	$error = array();
	if(isset($_POST['birth_day']) && !empty($_POST['birth_day'])){
		$birth_day = $_POST['birth_day'];
		$birth_day_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id AND birth_day = :birth_day ", ['user_id' => $_SESSION['user_id'], 'birth_day' => $birth_day]);
		if ( count($birth_day_check) == 0 ){
			$birth_day_user_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
			if (count($birth_day_user_check) == 0 ){
				$birth_day_result = query($pdo, "INSERT INTO profiles (id, user_id, birth_day) VALUES ('', :user_id, :birth_day) ", ['user_id' => $_SESSION['user_id'], 'birth_day' => $birth_day]);
				if(!$birth_day_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your birthday was succesfully changed.';
				}
			}else{
				$birth_day_result = query($pdo, " UPDATE profiles SET birth_day = :birth_day WHERE user_id= :user_id ", ['birth_day' => $birth_day, 'user_id' => $_SESSION['user_id']]);
				if(!$birth_day_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your birthday was succesfully changed.';
				}
			}
		}
	}
}

if(isset($_POST['profile_submit'])){
	if(isset($_POST['birth_month']) && !empty($_POST['birth_month'])){
		$birth_month = $_POST['birth_month'];
		$birth_month_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id AND birth_month = :birth_month ", ['user_id' => $_SESSION['user_id'], 'birth_month' => $birth_month]);
		if (count($birth_month_check)==0){
			$birth_month_user_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
			if (count($birth_month_user_check)==0){
				$birth_month_result = query($pdo, "INSERT INTO profiles (id, user_id, birth_month) VALUES ('', :user_id, :birth_month ) ", ['user_id' => $_SESSION['user_id'], 'birth_month' => $birth_month]);
				if(!$birth_month_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your birthmonth was succesfully changed.';
				}
			}else{
				$birth_month_result = query($pdo, " UPDATE profiles SET birth_month = :birth_month WHERE user_id = :user_id ", ['birth_month' => $birth_month, 'user_id' => $_SESSION['user_id']]);
				if(!$birth_month_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your birthmonth was succesfully changed.';
				}
			}
		}
	}
}		

if(isset($_POST['profile_submit'])){
	if(isset($_POST['birth_year']) && !empty($_POST['birth_year'])){
		$birth_year = $_POST['birth_year'];
		$birth_year_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id AND birth_year = :birth_year ", ['user_id' => $_SESSION['user_id'], 'birth_year' => $birth_year]);
		if (count($birth_year_check)==0){
			$birth_year_user_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
			if (count($birth_year_user_check)==0){
				$birth_year_result = query($pdo, "INSERT INTO profiles (id, user_id, birth_year) VALUES ('', :user_id, :birth_year ) ", ['user_id' => $_SESSION['user_id'], 'birth_year' => $birth_year]);
				if(!$birth_year_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your birthyear was succesfully changed.';
				}
			}else{
				$birth_year_result = query($pdo, " UPDATE profiles SET birth_year = :birth_year WHERE user_id = :user_id ", ['birth_year' => $birth_year, 'user_id' => $_SESSION['user_id']]);
				if(!$birth_year_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your birthyear was succesfully changed.';
				}
			}
		}		
	}
}

if(isset($_POST['profile_submit'])){
	if(isset($_POST['country']) && !empty($_POST['country'])){
		$country = $_POST['country'];
		$country_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id AND country = :country ", ['user_id' => $_SESSION['user_id'], 'country' => $country]);
		if (count($country_check)==0){
			$country_user_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
			if (count($country_user_check)==0){
				$country_result = query($pdo, "INSERT INTO profiles (id, user_id, country) VALUES ('', :user_id, :country ) ", ['user_id' => $_SESSION['user_id'], 'country' => $country]);
				if(!$country_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your country was succesfully changed.';
				}
			}else{
				$country_result = query($pdo, " UPDATE profiles SET country = :country WHERE user_id = :user_id ", ['country' => $country, 'user_id' => $_SESSION['user_id']]);
				if(!$country_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your country was succesfully changed.';
				}
			}
		}		
	}
}

if(isset($_POST['profile_submit'])){
	if(isset($_POST['city']) && !empty($_POST['city'])){
		$city = $_POST['city'];
		$city_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id AND city = :city ", ['user_id' => $_SESSION['user_id'], 'city' => $city]);
		if (count($city_check)==0){
			$city_user_check = query($pdo, "SELECT * FROM profiles WHERE user_id = :user_id ", ['user_id' => $_SESSION['user_id']]);
			if (count($city_user_check)==0){
				$city_result = query($pdo, "INSERT INTO profiles (id, user_id, city) VALUES ('', :user_id, :city ) ", ['user_id' => $_SESSION, 'city' => $city]);
				if(!$city_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your city was succesfully changed.';
				}
			}else{
				$city_result = query($pdo, " UPDATE profiles SET city = :city WHERE user_id = :user_id ", ['city' => $city, 'user_id' => $_SESSION['user_id']]);
				if(!$city_result){
					header('Location:prompt.php?x=3');
				}else{
					$error[] = 'Your city was succesfully changed.';
				}
			}
		}	
	}
}
if(isset($_POST['profile_submit'])){
	$name = $_FILES['profile_picture']['name'];
	$extension = strtolower(substr($name, strpos($name, '.') +1));
	$name = $_SESSION['username'].'_pf.'.$extension;
	$tmp_name = $_FILES['profile_picture']['tmp_name'];
	$type = $_FILES['profile_picture']['type'];
	$size = $_FILES['profile_picture']['size'];
	$max_size= 2097152;
	if(isset($name) && !empty($name) && isset($extension) && !empty($extension)){
		if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif'){
			if($size<$max_size){
				$location = '/home/a9862957/public_html/images/users/'.$_SESSION['username'].'/';
				if (move_uploaded_file($tmp_name, $location.$name)){
					$error[] = 'Profile picture was succesfully uploaded.';
				}
			}else{
				$error[] = 'Your profile pictures can only be 2 megabytes big. Please choose a smaller file.';
			}
		}else{
			$error[] = 'Please choose a valid imagetype for your profile picture. Valid imagetypes are: .jpg, .jpeg, .png and .gif.';
		}
	}
}

if(isset($_POST['profile_submit'])){
	if(isset($_POST['pass_new_1']) && !empty($_POST['pass_new_1'])){
		if(isset($_POST['pass_new_2']) && !empty($_POST['pass_new_2'])){
			$pass1 = $_POST['pass_new_1'];
			$pass2 = $_POST['pass_new_2'];
			if ($pass1 == $pass2){
				$pass_md5 = md5($pass1);
				$pass_check = query($pdo, "SELECT * FROM users WHERE password = :pass_md5 AND user_id = :user_id ", ['pass_md5' => $pass_md5, 'user_id' => $_SESSION['user_id']]);
				if(count($pass_check)==0){
					$result_passchange = query($pdo, " UPDATE users SET password = :pass_md5 WHERE user_id = :user_id ", ['pass_md5' => $pass_md5, 'user_id' => $_SESSION['user_id']]);
					if(!$result_passchange){
						$error_message = '<span class="error">';
						foreach($error as $key => $values){
							$error_message.= "$values";
						} // prompt 3
					}else{
						session_destroy();
						header('Location:prompt.php?x=12');
					}
				}else{
					$error[] = "Please enter a new password."; // prompt 13
				}
			}else{
				$error[] = "Your passwords did not match, please try again."; // prompt 11
			}
		}else{
			$error[] = "Please repeat your new password."; // prompt 14
		}
	}else if(isset($_POST['email_new_1']) && !empty($_POST['email_new_1'])){
		if(isset($_POST['email_new_2']) && !empty($_POST['email_new_2'])){
			$email1 = $_POST['email_new_1'];
			$email2 = $_POST['email_new_2'];
			if ($email1 == $email2){
				$email_check = query($pdo, " SELECT * FROM users WHERE email = :email1 AND user_id = :user_id ", ['email1' => $email1, 'user_id' => $_SESSION['user_id']]);
				if (count($email_check)==0){
					$result_emailchange = query($pdo, " UPDATE users SET email = :email1 WHERE user_id = :user_id ", ['email1' => $email1, 'user_id' => $_SESSION['user_id']]);
					if(!$result_emailchange){
						$error_message = '<span class="error">';
						foreach($error as $key => $values){
							$error_message.= "$values";
						}
						$error_message.="</span><br/><br/>";
					}else{
						header('Location:prompt.php?x=15');
					}
				}else{
					$error[] = "Please enter a new emailaddress."; // prompt 17
				}
			}else{
				$error[] = "Your emailadresses did not match, please try again."; // prompt 16
			}
		}else{
			$error[] = "Please repeat your new emailaddress."; // prompt 18
		}
	}else{
		// Not sure what to do here :S Nothing maybe?
	}
}

if(isset($error) && !empty($error)){
	$error_message = '<span class="error">';
	foreach($error as $key => $values){
		$error_message.= "$values";
	}
	$error_message.="</span><br/><br/>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php Head(); ?>
	<title>Somentus - Profile</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/account.css">
	<link rel="stylesheet" href="css/profile.css">
</head>
<body>
	<div id="wrapper">
		<?php headerAndSearchCode($pdo); ?>
		<aside>
			<?php persons_Left($pdo); ?>
		</aside>

		<section id="generalform">
			<form class="container" method="POST" action="" enctype="multipart/form-data">
				<?php if(isset($error) && !empty($error)) { echo $error_message; } ?>
				<div id="right_left_side" >
					<div class="field">
						<label for="pass_new_1">New password:</label>
						<input type="password" id="form_right" name="pass_new_1" placeholder="New password"/>
					</div>
					<br>
					<div class="field">
						<label for="pass_new_2">Repeat new password:</label>
						<input type="password" id="form_right" name="pass_new_2" placeholder="Repeat new password"/>
					</div>
					<br><br>
					<div class="field">
						<label for="email_new_1">New email address:</label>
						<input type="text" id="form_right" name="email_new_1" placeholder="New email address" />
					</div>
					<br>
					<div class="field">
						<label for="email_new_2">Repeat new email address:</label>
						<input type="text" id="form_right" name="email_new_2" placeholder="Repeat new email address" />
					</div>
					<br><br>
					<div class="field" >
						<label for="profile_picture">Profile picture:</label>
						<input type="file" name="profile_picture" />
					</div>
					<div class="field" >
						<input type="submit" name="profile_submit" id="submit" class="button" /><br>
					</div>
				</div>
				<div id="right_right_side" >
					<label for="birth_day">Day of birth:</label>
					<select name="birth_day" id="form_right" >
						<option value=<?php echo $default_day; ?>><?php echo $default_day; ?></option>
						<option value='01'>01</option>
						<option value='02'>02</option>
						<option value='03'>03</option>
						<option value='04'>04</option>
						<option value='05'>05</option>
						<option value='06'>06</option>
						<option value='07'>07</option>
						<option value='08'>08</option>
						<option value='09'>09</option>
						<option value='10'>10</option>
						<option value='11'>11</option>
						<option value='12'>12</option>
						<option value='13'>13</option>
						<option value='14'>14</option>
						<option value='15'>15</option>
						<option value='16'>16</option>
						<option value='17'>17</option>
						<option value='18'>18</option>
						<option value='19'>19</option>
						<option value='20'>20</option>
						<option value='21'>21</option>
						<option value='22'>22</option>
						<option value='23'>23</option>
						<option value='24'>24</option>
						<option value='25'>25</option>
						<option value='26'>26</option>
						<option value='27'>27</option>
						<option value='28'>28</option>
						<option value='29'>29</option>
						<option value='30'>30</option>
						<option value='31'>31</option>
					</select>
					<br><br>
					<label for="birth_month">Month of birth:</label>
					<select name="birth_month" id="form_right" >
						<option value=<?php echo $default_month; ?>><?php echo $default_month; ?></option>
						<option value='January'>January</option>
						<option value='February'>February</option>
						<option value='March'>March</option>
						<option value='April'>April</option>
						<option value='May'>May</option>
						<option value='June'>June</option>
						<option value='July'>July</option>
						<option value='August'>August</option>
						<option value='September'>September</option>
						<option value='October'>October</option>
						<option value='November'>November</option>
						<option value='December'>December</option>
					</select>
					<br><br>
					<label for="birth_year">Year of birth:</label>
					<select name="birth_year" id="form_right" >
						<option value="<?php echo $default_year; ?>"><?php echo $default_year; ?></option>
						<option value="2013">2013</option>
						<option value="2012">2012</option>
						<option value="2011">2011</option>
						<option value="2010">2010</option>
						<option value="2009">2009</option>
						<option value="2008">2008</option>
						<option value="2007">2007</option>
						<option value="2006">2006</option>
						<option value="2005">2005</option>
						<option value="2004">2004</option>
						<option value="2003">2003</option>
						<option value="2002">2002</option>
						<option value="2001">2001</option>
						<option value="2000">2000</option>
						<option value="1999">1999</option>
						<option value="1998">1998</option>
						<option value="1997">1997</option>
						<option value="1996">1996</option>
						<option value="1995">1995</option>
						<option value="1994">1994</option>
						<option value="1993">1993</option>
						<option value="1992">1992</option>
						<option value="1991">1991</option>
						<option value="1990">1990</option>
						<option value="1989">1989</option>
						<option value="1988">1988</option>
						<option value="1987">1987</option>
						<option value="1986">1986</option>
						<option value="1985">1985</option>
						<option value="1984">1984</option>
						<option value="1983">1983</option>
						<option value="1982">1982</option>
						<option value="1981">1981</option>
						<option value="1980">1980</option>
						<option value="1979">1979</option>
						<option value="1978">1978</option>
						<option value="1977">1977</option>
						<option value="1976">1976</option>
						<option value="1975">1975</option>
						<option value="1974">1974</option>
						<option value="1973">1973</option>
						<option value="1972">1972</option>
						<option value="1971">1971</option>
						<option value="1970">1970</option>
						<option value="1969">1969</option>
						<option value="1968">1968</option>
						<option value="1967">1967</option>
						<option value="1966">1966</option>
						<option value="1965">1965</option>
						<option value="1964">1964</option>
						<option value="1963">1963</option>
						<option value="1962">1962</option>
						<option value="1961">1961</option>
						<option value="1960">1960</option>
						<option value="1959">1959</option>
						<option value="1958">1958</option>
						<option value="1957">1957</option>
						<option value="1956">1956</option>
						<option value="1955">1955</option>
						<option value="1954">1954</option>
						<option value="1953">1953</option>
						<option value="1952">1952</option>
						<option value="1951">1951</option>
						<option value="1950">1950</option>
						<option value="1949">1949</option>
						<option value="1948">1948</option>
						<option value="1947">1947</option>
						<option value="1946">1946</option>
						<option value="1945">1945</option>
						<option value="1944">1944</option>
						<option value="1943">1943</option>
						<option value="1942">1942</option>
						<option value="1941">1941</option>
						<option value="1940">1940</option>
						<option value="1939">1939</option>
						<option value="1938">1938</option>
						<option value="1937">1937</option>
						<option value="1936">1936</option>
						<option value="1935">1935</option>
						<option value="1934">1934</option>
						<option value="1933">1933</option>
						<option value="1932">1932</option>
						<option value="1931">1931</option>
						<option value="1930">1930</option>
						<option value="1929">1929</option>
						<option value="1928">1928</option>
						<option value="1927">1927</option>
						<option value="1926">1926</option>
						<option value="1925">1925</option>
						<option value="1924">1924</option>
						<option value="1923">1923</option>
						<option value="1922">1922</option>
						<option value="1921">1921</option>
						<option value="1920">1920</option>
						<option value="1919">1919</option>
						<option value="1918">1918</option>
						<option value="1917">1917</option>
						<option value="1916">1916</option>
						<option value="1915">1915</option>
						<option value="1914">1914</option>
						<option value="1913">1913</option>
						<option value="1912">1912</option>
						<option value="1911">1911</option>
						<option value="1910">1910</option>
						<option value="1909">1909</option>
						<option value="1908">1908</option>
						<option value="1907">1907</option>
						<option value="1906">1906</option>
						<option value="1905">1905</option>
						<option value="1904">1904</option>
						<option value="1903">1903</option>
						<option value="1902">1902</option>
						<option value="1901">1901</option>
						<option value="1900">1900</option>
					</select>
					<br><br>
					<label for="country">Country:</label>
					<select name="country" id="form_right" >
						<option value="<?php echo $default_country; ?>"><?php echo $default_country; ?></option>
						<option value="Afghanistan" title="Afghanistan">Afghanistan</option>
						<option value="Åland Islands" title="Åland Islands">Åland Islands</option>
						<option value="Albania" title="Albania">Albania</option>
						<option value="Algeria" title="Algeria">Algeria</option>
						<option value="American Samoa" title="American Samoa">American Samoa</option>
						<option value="Andorra" title="Andorra">Andorra</option>
						<option value="Angola" title="Angola">Angola</option>
						<option value="Anguilla" title="Anguilla">Anguilla</option>
						<option value="Antarctica" title="Antarctica">Antarctica</option>
						<option value="Antigua and Barbuda" title="Antigua and Barbuda">Antigua and Barbuda</option>
						<option value="Argentina" title="Argentina">Argentina</option>
						<option value="Armenia" title="Armenia">Armenia</option>
						<option value="Aruba" title="Aruba">Aruba</option>
						<option value="Australia" title="Australia">Australia</option>
						<option value="Austria" title="Austria">Austria</option>
						<option value="Azerbaijan" title="Azerbaijan">Azerbaijan</option>
						<option value="Bahamas" title="Bahamas">Bahamas</option>
						<option value="Bahrain" title="Bahrain">Bahrain</option>
						<option value="Bangladesh" title="Bangladesh">Bangladesh</option>
						<option value="Barbados" title="Barbados">Barbados</option>
						<option value="Belarus" title="Belarus">Belarus</option>
						<option value="Belgium" title="Belgium">Belgium</option>
						<option value="Belize" title="Belize">Belize</option>
						<option value="Benin" title="Benin">Benin</option>
						<option value="Bermuda" title="Bermuda">Bermuda</option>
						<option value="Bhutan" title="Bhutan">Bhutan</option>
						<option value="Bolivia, Plurinational State of" title="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
						<option value="Bonaire, Sint Eustatius and Saba" title="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
						<option value="Bosnia and Herzegovina" title="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
						<option value="Botswana" title="Botswana">Botswana</option>
						<option value="Bouvet Island" title="Bouvet Island">Bouvet Island</option>
						<option value="Brazil" title="Brazil">Brazil</option>
						<option value="British Indian Ocean Territory" title="British Indian Ocean Territory">British Indian Ocean Territory</option>
						<option value="Brunei Darussalam" title="Brunei Darussalam">Brunei Darussalam</option>
						<option value="Bulgaria" title="Bulgaria">Bulgaria</option>
						<option value="Burkina Faso" title="Burkina Faso">Burkina Faso</option>
						<option value="Burundi" title="Burundi">Burundi</option>
						<option value="Cambodia" title="Cambodia">Cambodia</option>
						<option value="Cameroon" title="Cameroon">Cameroon</option>
						<option value="Canada" title="Canada">Canada</option>
						<option value="Cape Verde" title="Cape Verde">Cape Verde</option>
						<option value="Cayman Islands" title="Cayman Islands">Cayman Islands</option>
						<option value="Central African Republic" title="Central African Republic">Central African Republic</option>
						<option value="Chad" title="Chad">Chad</option>
						<option value="Chile" title="Chile">Chile</option>
						<option value="China" title="China">China</option>
						<option value="Christmas Island" title="Christmas Island">Christmas Island</option>
						<option value="Cocos (Keeling) Islands" title="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
						<option value="Colombia" title="Colombia">Colombia</option>
						<option value="Comoros" title="Comoros">Comoros</option>
						<option value="Congo" title="Congo">Congo</option>
						<option value="Congo, the Democratic Republic of the" title="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
						<option value="Cook Islands" title="Cook Islands">Cook Islands</option>
						<option value="Costa Rica" title="Costa Rica">Costa Rica</option>
						<option value="Côte d'Ivoire" title="Côte d'Ivoire">Côte d'Ivoire</option>
						<option value="Croatia" title="Croatia">Croatia</option>
						<option value="Cuba" title="Cuba">Cuba</option>
						<option value="Curaçao" title="Curaçao">Curaçao</option>
						<option value="Cyprus" title="Cyprus">Cyprus</option>
						<option value="Czech Republic" title="Czech Republic">Czech Republic</option>
						<option value="Denmark" title="Denmark">Denmark</option>
						<option value="Djibouti" title="Djibouti">Djibouti</option>
						<option value="Dominica" title="Dominica">Dominica</option>
						<option value="Dominican Republic" title="Dominican Republic">Dominican Republic</option>
						<option value="Ecuador" title="Ecuador">Ecuador</option>
						<option value="Egypt" title="Egypt">Egypt</option>
						<option value="El Salvador" title="El Salvador">El Salvador</option>
						<option value="Equatorial Guinea" title="Equatorial Guinea">Equatorial Guinea</option>
						<option value="Eritrea" title="Eritrea">Eritrea</option>
						<option value="Estonia" title="Estonia">Estonia</option>
						<option value="Ethiopia" title="Ethiopia">Ethiopia</option>
						<option value="Falkland Islands (Malvinas)" title="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
						<option value="Faroe Islands" title="Faroe Islands">Faroe Islands</option>
						<option value="Fiji" title="Fiji">Fiji</option>
						<option value="Finland" title="Finland">Finland</option>
						<option value="France" title="France">France</option>
						<option value="French Guiana" title="French Guiana">French Guiana</option>
						<option value="French Polynesia" title="French Polynesia">French Polynesia</option>
						<option value="French Southern Territories" title="French Southern Territories">French Southern Territories</option>
						<option value="Gabon" title="Gabon">Gabon</option>
						<option value="Gambia" title="Gambia">Gambia</option>
						<option value="Georgia" title="Georgia">Georgia</option>
						<option value="Germany" title="Germany">Germany</option>
						<option value="Ghana" title="Ghana">Ghana</option>
						<option value="Gibraltar" title="Gibraltar">Gibraltar</option>
						<option value="Greece" title="Greece">Greece</option>
						<option value="Greenland" title="Greenland">Greenland</option>
						<option value="Grenada" title="Grenada">Grenada</option>
						<option value="Guadeloupe" title="Guadeloupe">Guadeloupe</option>
						<option value="Guam" title="Guam">Guam</option>
						<option value="Guatemala" title="Guatemala">Guatemala</option>
						<option value="Guernsey" title="Guernsey">Guernsey</option>
						<option value="Guinea" title="Guinea">Guinea</option>
						<option value="Guinea-Bissau" title="Guinea-Bissau">Guinea-Bissau</option>
						<option value="Guyana" title="Guyana">Guyana</option>
						<option value="Haiti" title="Haiti">Haiti</option>
						<option value="Heard Island and McDonald Islands" title="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
						<option value="Holy See (Vatican City State)" title="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
						<option value="Honduras" title="Honduras">Honduras</option>
						<option value="Hong Kong" title="Hong Kong">Hong Kong</option>
						<option value="Hungary" title="Hungary">Hungary</option>
						<option value="Iceland" title="Iceland">Iceland</option>
						<option value="India" title="India">India</option>
						<option value="Indonesia" title="Indonesia">Indonesia</option>
						<option value="Iran, Islamic Republic of" title="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
						<option value="Iraq" title="Iraq">Iraq</option>
						<option value="Ireland" title="Ireland">Ireland</option>
						<option value="Isle of Man" title="Isle of Man">Isle of Man</option>
						<option value="Israel" title="Israel">Israel</option>
						<option value="Italy" title="Italy">Italy</option>
						<option value="Jamaica" title="Jamaica">Jamaica</option>
						<option value="Japan" title="Japan">Japan</option>
						<option value="Jersey" title="Jersey">Jersey</option>
						<option value="Jordan" title="Jordan">Jordan</option>
						<option value="Kazakhstan" title="Kazakhstan">Kazakhstan</option>
						<option value="Kenya" title="Kenya">Kenya</option>
						<option value="Kiribati" title="Kiribati">Kiribati</option>
						<option value="Korea, Democratic People's Republic of" title="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
						<option value="Korea, Republic of" title="Korea, Republic of">Korea, Republic of</option>
						<option value="Kuwait" title="Kuwait">Kuwait</option>
						<option value="Kyrgyzstan" title="Kyrgyzstan">Kyrgyzstan</option>
						<option value="Lao People's Democratic Republic" title="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
						<option value="Latvia" title="Latvia">Latvia</option>
						<option value="Lebanon" title="Lebanon">Lebanon</option>
						<option value="Lesotho" title="Lesotho">Lesotho</option>
						<option value="Liberia" title="Liberia">Liberia</option>
						<option value="Libya" title="Libya">Libya</option>
						<option value="Liechtenstein" title="Liechtenstein">Liechtenstein</option>
						<option value="Lithuania" title="Lithuania">Lithuania</option>
						<option value="Luxembourg" title="Luxembourg">Luxembourg</option>
						<option value="Macao" title="Macao">Macao</option>
						<option value="Macedonia, the former Yugoslav Republic of" title="Macedonia, the former Yugoslav Republic of">Macedonia, the former Yugoslav Republic of</option>
						<option value="Madagascar" title="Madagascar">Madagascar</option>
						<option value="Malawi" title="Malawi">Malawi</option>
						<option value="Malaysia" title="Malaysia">Malaysia</option>
						<option value="Maldives" title="Maldives">Maldives</option>
						<option value="Mali" title="Mali">Mali</option>
						<option value="Malta" title="Malta">Malta</option>
						<option value="Marshall Islands" title="Marshall Islands">Marshall Islands</option>
						<option value="Martinique" title="Martinique">Martinique</option>
						<option value="Mauritania" title="Mauritania">Mauritania</option>
						<option value="Mauritius" title="Mauritius">Mauritius</option>
						<option value="Mayotte" title="Mayotte">Mayotte</option>
						<option value="Mexico" title="Mexico">Mexico</option>
						<option value="Micronesia, Federated States of" title="Micronesia, Federated States of">Micronesia, Federated States of</option>
						<option value="Moldova, Republic of" title="Moldova, Republic of">Moldova, Republic of</option>
						<option value="Monaco" title="Monaco">Monaco</option>
						<option value="Mongolia" title="Mongolia">Mongolia</option>
						<option value="Montenegro" title="Montenegro">Montenegro</option>
						<option value="Montserrat" title="Montserrat">Montserrat</option>
						<option value="Morocco" title="Morocco">Morocco</option>
						<option value="Mozambique" title="Mozambique">Mozambique</option>
						<option value="Myanmar" title="Myanmar">Myanmar</option>
						<option value="Namibia" title="Namibia">Namibia</option>
						<option value="Nauru" title="Nauru">Nauru</option>
						<option value="Nepal" title="Nepal">Nepal</option>
						<option value="Netherlands" title="Netherlands">Netherlands</option>
						<option value="New Caledonia" title="New Caledonia">New Caledonia</option>
						<option value="New Zealand" title="New Zealand">New Zealand</option>
						<option value="Nicaragua" title="Nicaragua">Nicaragua</option>
						<option value="Niger" title="Niger">Niger</option>
						<option value="Nigeria" title="Nigeria">Nigeria</option>
						<option value="Niue" title="Niue">Niue</option>
						<option value="Norfolk Island" title="Norfolk Island">Norfolk Island</option>
						<option value="Northern Mariana Islands" title="Northern Mariana Islands">Northern Mariana Islands</option>
						<option value="Norway" title="Norway">Norway</option>
						<option value="Oman" title="Oman">Oman</option>
						<option value="Pakistan" title="Pakistan">Pakistan</option>
						<option value="Palau" title="Palau">Palau</option>
						<option value="Palestinian Territory, Occupied" title="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
						<option value="Panama" title="Panama">Panama</option>
						<option value="Papua New Guinea" title="Papua New Guinea">Papua New Guinea</option>
						<option value="Paraguay" title="Paraguay">Paraguay</option>
						<option value="Peru" title="Peru">Peru</option>
						<option value="Philippines" title="Philippines">Philippines</option>
						<option value="Pitcairn" title="Pitcairn">Pitcairn</option>
						<option value="Poland" title="Poland">Poland</option>
						<option value="Portugal" title="Portugal">Portugal</option>
						<option value="Puerto Rico" title="Puerto Rico">Puerto Rico</option>
						<option value="Qatar" title="Qatar">Qatar</option>
						<option value="Réunion" title="Réunion">Réunion</option>
						<option value="Romania" title="Romania">Romania</option>
						<option value="Russian Federation" title="Russian Federation">Russian Federation</option>
						<option value="Rwanda" title="Rwanda">Rwanda</option>
						<option value="Saint Barthélemy" title="Saint Barthélemy">Saint Barthélemy</option>
						<option value="Saint Kitts and Nevis" title="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
						<option value="Saint Lucia" title="Saint Lucia">Saint Lucia</option>
						<option value="Saint Martin (French part)" title="Saint Martin (French part)">Saint Martin (French part)</option>
						<option value="Saint Pierre and Miquelon" title="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
						<option value="Saint Vincent and the Grenadines" title="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
						<option value="Samoa" title="Samoa">Samoa</option>
						<option value="San Marino" title="San Marino">San Marino</option>
						<option value="Sao Tome and Principe" title="Sao Tome and Principe">Sao Tome and Principe</option>
						<option value="Saudi Arabia" title="Saudi Arabia">Saudi Arabia</option>
						<option value="Senegal" title="Senegal">Senegal</option>
						<option value="Serbia" title="Serbia">Serbia</option>
						<option value="Seychelles" title="Seychelles">Seychelles</option>
						<option value="Sierra Leone" title="Sierra Leone">Sierra Leone</option>
						<option value="Singapore" title="Singapore">Singapore</option>
						<option value="Sint Maarten (Dutch part)" title="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
						<option value="Slovakia" title="Slovakia">Slovakia</option>
						<option value="Slovenia" title="Slovenia">Slovenia</option>
						<option value="Solomon Islands" title="Solomon Islands">Solomon Islands</option>
						<option value="Somalia" title="Somalia">Somalia</option>
						<option value="South Africa" title="South Africa">South Africa</option>
						<option value="South Sudan" title="South Sudan">South Sudan</option>
						<option value="Spain" title="Spain">Spain</option>
						<option value="Sri Lanka" title="Sri Lanka">Sri Lanka</option>
						<option value="Sudan" title="Sudan">Sudan</option>
						<option value="Suriname" title="Suriname">Suriname</option>
						<option value="Svalbard and Jan Mayen" title="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
						<option value="Swaziland" title="Swaziland">Swaziland</option>
						<option value="Sweden" title="Sweden">Sweden</option>
						<option value="Switzerland" title="Switzerland">Switzerland</option>
						<option value="Syrian Arab Republic" title="Syrian Arab Republic">Syrian Arab Republic</option>
						<option value="Taiwan, Province of China" title="Taiwan, Province of China">Taiwan, Province of China</option>
						<option value="Tajikistan" title="Tajikistan">Tajikistan</option>
						<option value="Tanzania, United Republic of" title="Tanzania, United Republic of">Tanzania, United Republic of</option>
						<option value="Thailand" title="Thailand">Thailand</option>
						<option value="Timor-Leste" title="Timor-Leste">Timor-Leste</option>
						<option value="Togo" title="Togo">Togo</option>
						<option value="Tokelau" title="Tokelau">Tokelau</option>
						<option value="Tonga" title="Tonga">Tonga</option>
						<option value="Trinidad and Tobago" title="Trinidad and Tobago">Trinidad and Tobago</option>
						<option value="Tunisia" title="Tunisia">Tunisia</option>
						<option value="Turkey" title="Turkey">Turkey</option>
						<option value="Turkmenistan" title="Turkmenistan">Turkmenistan</option>
						<option value="Turks and Caicos Islands" title="Turks and Caicos Islands">Turks and Caicos Islands</option>
						<option value="Tuvalu" title="Tuvalu">Tuvalu</option>
						<option value="Uganda" title="Uganda">Uganda</option>
						<option value="Ukraine" title="Ukraine">Ukraine</option>
						<option value="United Arab Emirates" title="United Arab Emirates">United Arab Emirates</option>
						<option value="United Kingdom" title="United Kingdom">United Kingdom</option>
						<option value="United States" title="United States">United States</option>
						<option value="United States Minor Outlying Islands" title="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
						<option value="Uruguay" title="Uruguay">Uruguay</option>
						<option value="Uzbekistan" title="Uzbekistan">Uzbekistan</option>
						<option value="Vanuatu" title="Vanuatu">Vanuatu</option>
						<option value="Venezuela, Bolivarian Republic of" title="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of</option>
						<option value="Viet Nam" title="Viet Nam">Viet Nam</option>
						<option value="Virgin Islands, British" title="Virgin Islands, British">Virgin Islands, British</option>
						<option value="Virgin Islands, U.S." title="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
						<option value="Wallis and Futuna" title="Wallis and Futuna">Wallis and Futuna</option>
						<option value="Western Sahara" title="Western Sahara">Western Sahara</option>
						<option value="Yemen" title="Yemen">Yemen</option>
						<option value="Zambia" title="Zambia">Zambia</option>
						<option value="Zimbabwe" title="Zimbabwe">Zimbabwe</option>
					</select>
					<br><br>
					<label for="city">City:</label>
					<input type="text" name="city" id="form_right" placeholder="<?php echo $default_city; ?>" />
				</div>
				<br>
			</form>
		</section>
		<?php footerCode(); ?>
	</div>
</body>
</html>