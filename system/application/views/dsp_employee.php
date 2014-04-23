<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Detail zaměstnance
                </h3>
            </div>
            <div class="panel-body">
                <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                <form class="form-horizontal" role="form" action="{site_url('cadmin/updateEmployee')}" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="ID" value="{$oEmployee->ID}">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Jméno</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input1" name="name" placeholder="Jméno" value="{$oEmployee->name}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input2" class="col-sm-2 control-label">Telefon</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input2" name="tel" placeholder="Telefon" value="{$oEmployee->tel}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input5" class="col-sm-2 control-label">Město</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input5" name="address1" placeholder="Město" value="{$oEmployee->address1}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input7" class="col-sm-2 control-label">PSČ</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input7" name="postalCode" placeholder="PSČ" value="{$oEmployee->postalCode}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input3" class="col-sm-2 control-label">Příjmení</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input3" name="surname" placeholder="Příjmení" value="{$oEmployee->surname}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input4" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="input4" name="email" placeholder="Email"  value="{$oEmployee->email}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input6" class="col-sm-2 control-label">Ulice</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input6" name="address2" placeholder="Ulice" value="{$oEmployee->address2}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input8" class="col-sm-2 control-label">Login</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input8" name="login" placeholder="Login" value="{$oEmployee->login}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input9" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input9" name="role" placeholder="Role" value="{$oEmployee->role}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input10" class="col-sm-2 control-label">Aktivní</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="input10" name="active">
                                        {if {$oEmployee->active} eq 0} selected="selected"{/if}
                                        <option value="0"  {if {$oEmployee->active} eq 0} selected="selected"{/if} >Neaktivní</option>
                                        <option value="1"  {if {$oEmployee->active} eq 1} selected="selected"{/if} >Aktivní</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success col-md-offset-10">Uložit</button>
                </form>
            </div>
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>

