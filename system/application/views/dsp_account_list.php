<div class="row clearfix">
    <div class="col-md-3 column">
        {*include file="./block/dsp_menu_admin.php"*}
    </div>
    {foreach $aAccounts as $oAccount}
    {/foreach}
    
</div>

<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu_admin.php"}
    </div>
    <div class="col-md-9 column">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Seznam zaměstnanců
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form class="form-inline col-md-6" role="form">
                          <div class="form-group">
                            <label class="sr-only" for="searchText">Email address</label>
                            <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Text">
                          </div>
                          <button type="submit" class="btn btn-default">Hledat</button>

                    </form>
                    <div class=" col-md-6">
                        <a href="{site_url('cadvice/showAccount')}/">
                            <button  class="btn btn-success col-md-offset-8">Přidat záznam</button>
                        </a>
                    </div>
                </div>


                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Číslo účtu
                            </th>
                            <th>
                                Typ účtu
                            </th>
                            <th>
                                Zůstatek
                            </th>
                            <th>
                                Disponibilní zůstatek
                            </th>
                            <th>
                                Klient
                            </th>
                            <th>
                                Email
                            </th>
                            <th class="col-md-1">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $aAccounts as $oAccount}
                            <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                            <tr  class='clickableRow' href="{site_url('cadvice/showAccount')}/{$oAccount->ID}">
                                <td>
                                    {$oAccount->ID}
                                </td>
                                <td>
                                    {$oAccount->number}
                                </td>
                                <td>
                                    {if $oAccount->type}{$oAccount->type->name}{/if}
                                </td>
                                <td>
                                    {$oAccount->value}
                                </td>
                                <td>
                                    {$oAccount->avalaibleValue}
                                </td>
                                <td>
                                    {if $oAccount->client}{$oAccount->client->name} {$oAccount->client->surname}{/if}
                                </td>
                                <td>
                                    {if $oAccount->client}{$oAccount->client->email}{/if}
                                </td>
                                <td class="dont-select">
                                    <a href="{site_url('cadvice/removeAccount')}/{$oAccount->ID}">
                                        <button type="button" class="btn btn-danger btn-md">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
                {* Přidáme až při rozšiřování
                <div class="row clearfix">
                    <div class="col-md-offset-8 col-md-4 column ">
                        <ul class="pagination pagination-sm">
                            <li>
                                <a href="#">Prev</a>
                            </li>
                            <li>
                                <a href="#">1</a>
                            </li>
                            <li>
                                <a href="#">2</a>
                            </li>
                            <li>
                                <a href="#">3</a>
                            </li>
                            <li>
                                <a href="#">4</a>
                            </li>
                            <li>
                                <a href="#">5</a>
                            </li>
                            <li>
                                <a href="#">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
                *}
            </div>
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</div>