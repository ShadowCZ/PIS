<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu.php"}
    </div>
    <div class="col-md-9 column">
        <ol class="breadcrumb">
            <li> <a href="{site_url('/cadvice/showClientList')}">Klienti</a></li>
            <li class="active">Účty</li>
        </ol>
        {include file="./block/dsp_message.php"}
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Seznam účtů
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
                        {if $iClient > 0}
                            <a href="{site_url('cadvice/showAccountCreate')}/{$iClient}">
                                <button  class="btn btn-success col-md-offset-8">Založit nový účet</button>
                            </a>
                        {/if}
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
                            <th class="col-md-2">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $aAccounts as $oAccount}
                        
                            <tr  class='clickableRow' href="{site_url('cadvice/showAccountDetail')}/{$oAccount->ID}">
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
                                    {$oAccount->availableValue}
                                </td>
                                <td>
                                    {if $oAccount->client}{$oAccount->client->name} {$oAccount->client->surname}{/if}
                                </td>
                                <td>
                                    {if $oAccount->client}{$oAccount->client->email}{/if}
                                </td>
                                <td class="dont-select">
                                    <a href="{site_url('cadvice/showAccount')}/{$oAccount->ID}">
                                        <button type="button" class="btn btn-success btn-md">
                                            <span class="glyphicon glyphicon-cog"></span>
                                        </button>
                                    </a>
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