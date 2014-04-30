<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Detail klienta
                </h3>
            </div>
            <div class="panel-body">
                <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                <form class="form-horizontal" role="form" action="{site_url('cadmin/updateClient/')}{if $oClient->ID}/{$oClient->ID}{/if}" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="ID" value="{if $oClient->ID}{$oClient->ID}{/if}">
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Jméno</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input1" name="name" placeholder="Jméno" value="{if $oClient->name}{$oClient->name}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input2" class="col-sm-2 control-label">Telefon</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input2" name="tel" placeholder="Telefon" value="{if $oClient->tel}{$oClient->tel}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input5" class="col-sm-2 control-label">Město</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit."  type="text" class="form-control" id="input5" name="address1" placeholder="Město" value="{if $oClient->address1}{$oClient->address1}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input7" class="col-sm-2 control-label">PSČ</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input7" name="postalCode" placeholder="PSČ" value="{if $oClient->postalCode}{$oClient->postalCode}{/if}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input3" class="col-sm-2 control-label">Příjmení</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input3" name="surname" placeholder="Příjmení" value="{if $oClient->surname}{$oClient->surname}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input4" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="email" class="form-control" id="input4" name="email" placeholder="Email"  value="{if $oClient->email}{$oClient->email}{/if}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input6" class="col-sm-2 control-label">Ulice</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input6" name="address2" placeholder="Ulice" value="{if $oClient->address2}{$oClient->address2}{/if}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input8" class="col-sm-2 control-label">Osobni číslo</label>
                                <div class="col-sm-10">
                                    <input required title="Toto pole je potřeba vyplnit." type="text" class="form-control" id="input8" name="personalNumber" placeholder="Osobni číslo" value="{if $oClient->personalNumber}{$oClient->personalNumber}{/if}">
                                </div>
                            </div>
                        
                        </div>
                        <div class="col-md-6">
                            
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

