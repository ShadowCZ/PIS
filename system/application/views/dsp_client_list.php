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
                        <a href="{site_url('cadvice/showClient')}/">
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
                                Jméno
                            </th>
                            <th>
                                Příjmení
                            </th>
                            <th>
                                Telefon
                            </th>
                            <th>
                                Email
                            </th>
                            <th class="col-md-1">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $aClients as $oClient}
                            <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                            <tr  class='clickableRow' href="{site_url('cadvice/showClient')}/{$oClient->ID}">
                                <td>
                                    {$oClient->ID}
                                </td>
                                <td>
                                    {$oClient->name}
                                </td>
                                <td>
                                    {$oClient->surname}
                                </td>
                                <td>
                                    {$oClient->tel}
                                </td>
                                <td>
                                    {$oClient->email}
                                </td>
                                <td class="dont-select">
                                    <a href="{site_url('cadvice/removeClient')}/{$oClient->ID}">
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