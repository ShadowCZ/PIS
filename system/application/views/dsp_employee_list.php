<script type="text/javascript">
var cityEditId = 0;

onload=function(){
    $('#search').submit(function() {
        search();
        return false;
    });
    $('#searchText').keyup(function() {
        search();
    });
}

function search() {
    var search = $('#searchText').val();
    $.post("{site_url('cadmin/AJAXGetEmployeeList')}/", { sFilter: search}, function(data) {
        $('#employee_content').html(data);
        $(".clickableRow").click(function(event) {
        window.e = event;
            if (event.target.className.indexOf("dont-select") == -1 && !$(event.target).parents(".dont-select").length) {
                window.document.location = $(this).attr("href");
            }
        });
    });
}
</script>

<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu.php"}
    </div>
    <div class="col-md-9 column">
        <ol class="breadcrumb">
            <li class="active">Zaměstnanci</li>
        </ol>
        {include file="./block/dsp_message.php"}
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Seznam zaměstnanců
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form id="search" class="form-inline col-md-6" role="form">
                          <div class="form-group">
                            <label class="sr-only" for="searchText">Email address</label>
                            <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Text">
                          </div>
                          <button id="searchBtn" type="submit" class="btn btn-default">Hledat</button>

                    </form>
                    <div class=" col-md-6">
                        <a href="{site_url('cadmin/createEmployee')}/">
                            <button  class="btn btn-success col-md-offset-8">Přidat zaměstnance</button>
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
                    <tbody id="employee_content">
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
                                    {if $oEmployee->role}{$oEmployee->role->name}{/if}
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
                                <td class="dont-select">
                                    <a href="{site_url('cadmin/removeEmployee')}/{$oEmployee->ID}">
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