<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

ob_start();
//$usuario = $_POST['usuario'];
//$senha = $_POST['senha'];

if (isset($_POST['usuario']) && isset($_POST['senha'])){

	$username = $_POST['usuario'];
	$password = $_POST['senha'];
	$server = '10.194.250.111';
	$domain = '@governo.gdfnet.df';
	$port = 389;

	$connection = ldap_connect($server, $port);
	if (!$connection) {
    		exit('Connection failed');
	}

	// Help talking to AD
	ldap_set_option($connection , LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connection , LDAP_OPT_REFERRALS, 0);

	$bind = @ldap_bind($connection, $username.$domain, $password);
	if (!$bind) {
    		exit('Binding failed');
	}

	// This is where you can do your work
	echo 'Hello from LDAP';

	ldap_close($connection );
}

?>
<html>
<body>
  <form name="frm" method="post" >
&nbsp;&nbsp;&nbsp;<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3"><b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PREENCHA SEU USUÁRIO E SENHA DA REDEB </b>
		</td>
	</tr>
	<tr>
		<td width="13%">&nbsp;</td>
		<td width="54%">&nbsp;</td>
		<td width="33%">&nbsp;</td>
	</tr>
	<tr>
		<td width="13%" align="right"><b><font size="2">Usuário:&nbsp;&nbsp;&nbsp;
		</font></b></td>
		<td width="54%"> <input type="text" name="usuario"  size="25" maxlength="25"></td>
		<td width="33%">&nbsp;</td>
	</tr>
	<tr>
		<td width="13%" align="right">&nbsp;</td>
		<td width="54%">&nbsp;</td>
		<td width="33%">&nbsp;</td>
	</tr>
	<tr>
		<td width="13%" align="right"><b><font size="2">Senha:&nbsp;&nbsp;&nbsp;&nbsp;
		</font></b></td>
		<td width="54%"> <input type="password" name="senha"  size="16" maxlength="16"></td>
		<td width="33%">&nbsp;</td>
	</tr>
	<tr>
		<td width="13%" align="right">&nbsp;</td>
		<td width="54%">&nbsp;</td>
		<td width="33%">&nbsp;</td>
	</tr>
	<tr>
		<td width="13%" align="right">&nbsp;</td>
		<td width="54%"><input type="submit" name="Submit" value="VERIFICAR" ></td>
		<td width="33%"></form></td>
	</tr>
</table>

</body>
</html>
<?
	ob_end_flush();
?>
