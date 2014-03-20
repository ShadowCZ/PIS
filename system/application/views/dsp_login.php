<div id="container">
	<h1>Banka</h1>

	<div id="body">
        <p align="right">Ukázka jak psát odkazy:{anchor uri="cmain/registration/" label="Registrace"}</p>
        <h2>Login:</h2>
        <form method="post" action="{site_url('cmain/doLogin')}">
            <table>
                <tr><th>Login</th><td><input name="login" type="text"></td></tr>
                <tr><th>Heslo</th><td><input name="pass" type="password"></td></tr>
                <tr><td><td align="right"><input type="submit" value="Přihlásit" name="submit"></td></tr>
            </table>
        </form>
	</div>
</div>