<content class="col-md-12 container">
    {include file="./block/dsp_message.php"}
    <div class="col-md-offset-4 col-md-4">
        <form method="post" action="{site_url('cmain/doLogin')}">
            <div class="form-group">
                <label for="exampleInputLogin">Login</label>
                <input  name="login" type="text" class="form-control" id="exampleInputLogin" placeholder="Login" value="admin">
            </div>
            <div class="form-group">
                <label for="exampleInputPass">Heslo</label>
                <input  name="pass" type="password"class="form-control" id="exampleInputPass" placeholder="Password" value="admin">
            </div>
            <div class="text-right">    {anchor uri="cmain/registration/" label="Registrace"}</div>
            <div class="text-right">
                <button type="submit" class="btn btn-default">Přihlásit</button>
            </div>
        </form>
    </div>
</content>

