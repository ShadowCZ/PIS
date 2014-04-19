<header class="col-md-12">
    <nav class="navbar navbar-default col-md-6 col-md-offset-3" role="navigation">    
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active">
                    <h3>
                        Důvěryhodná banka
                    </h3>
                </li>
            </ul>
        </div>
    </nav>
</header>
<content class="col-md-12 container">
    <div class="col-md-offset-4 col-md-4">
        <form method="post" action="{site_url('cmain/doLogin')}">
            <div class="form-group">
                <label for="exampleInputLogin">Login</label>
                <input  name="login" type="text" class="form-control" id="exampleInputLogin" placeholder="Login">
            </div>
            <div class="form-group">
                <label for="exampleInputPass">Heslo</label>
                <input  name="pass" type="password"class="form-control" id="exampleInputPass" placeholder="Password" value="t">
            </div>
            <div class="text-right">    {anchor uri="cmain/registration/" label="Registrace"}</div>
            <div class="text-right">
                <button type="submit" class="btn btn-default">Přihlásit</button>
            </div>
        </form>
    </div>
</content>

