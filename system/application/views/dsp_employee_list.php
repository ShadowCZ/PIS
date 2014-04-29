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
                <form class="form-inline" role="form">
                      <div class="form-group">
                        <label class="sr-only" for="searchText">Email address</label>
                        <input type="text" class="form-control" id="searchText" placeholder="Text">
                      </div>
                      <button type="submit" class="btn btn-default">Hledat</button>
                </form>

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
                                Role
                            </th>
                            <th>
                                Telefon
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Aktivní
                            </th>
                            <th>
                                IP
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $aEmployees as $oEmployee}
                            <!-- BUG: vim, ze ta adresa je blbe, nevim jak ji udelat dobre -->
                            <tr  class='clickableRow' href="{site_url('cadmin/showEmployee')}/{$oEmployee->ID}">
                                <td>
                                    {$oEmployee->ID}
                                </td>
                                <td>
                                    {$oEmployee->name}
                                </td>
                                <td>
                                    {$oEmployee->surname}
                                </td>
                                <td>
                                    {$oEmployee->role->name}
                                </td>
                                <td>
                                    {$oEmployee->tel}
                                </td>
                                <td>
                                    {$oEmployee->email}
                                </td>
                                <td>
                                    {if $oEmployee->active}Ano{else}Ne{/if}
                                </td>
                                <td>
                                    {$oEmployee->lastIp}
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