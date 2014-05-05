<div class="row clearfix">
    <div class="col-md-3 column">
        {include file="./block/dsp_menu.php"}
    </div>
    <div class="col-md-9 column">
    {include file="./block/dsp_message.php"}
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Přehled operací
                </h3>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input10" class="col-sm-2 control-label">Účet</label>
                                <div class="col-sm-10">
                                     <select class="form-control" id="input10" name="account">
                                        <option value="1">Ucet 1</option>
                                        {*
                                        {if ! empty($aType)}
                                            {foreach $aType as $oType}
                                                <option value="{$oType->ID}" {if $oAccount->ID && $oType->ID == $oAccount->type} selected="selected"{/if}>{$oType->name}</option>
                                            {/foreach}
                                        {/if}
                                        *}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="datepicker" class="col-sm-2 control-label">Od</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="datepicker" name="fromDate" value="{$fromDate}">
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input11" class="col-sm-2 control-label">Klient</label>
                                <div class="col-sm-10">
                                     <select class="form-control" id="input11" name="client">
                                        <option value="1">Klient 1</option>
                                        {*
                                        {if ! empty($aType)}
                                            {foreach $aType as $oType}
                                                <option value="{$oType->ID}" {if $oAccount->ID && $oType->ID == $oAccount->type} selected="selected"{/if}>{$oType->name}</option>
                                            {/foreach}
                                        {/if}
                                        *}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="datepicker2" class="col-sm-2 control-label">Do</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="datepicker2" name="toDate" value="{$toDate}">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default col-md-offset-10">Hledat</button>
                    <br><br>
                </form>

                <div class="panel panel-success">
                   <div class="panel-heading">
                        <h3 class="panel-title">
                            Operace
                        </h3>
                    </div>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Osoba
                            </th>
                            <th>
                                Zaměstnanec
                            </th>
                            <th>
                                Datum
                            </th>
                            <th>
                                Částka
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $aOperations as $oOperation}
                            <tr>
                                <td>
                                    {$oOperation->ID}
                                </td>
                                <td>
                                    {if $oOperation->delegatedPerson}{$oOperation->delegatedPerson->client->name} {$oOperation->delegatedPerson->client->surname}{/if}
                                </td>
                                <td>
                                    {if $oOperation->employee}{$oOperation->employee->name}{/if}
                                </td>
                                <td>
                                    {$oOperation->date}
                                </td>
                                <td>
                                    {$oOperation->value}
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
                <space></space>
                <div class="text-right">
                    <a href="{site_url('ctransaction/generateOperationsToPDF')}/{if $iClient}{$iClient}{else}0{/if}/{if $iAccount}{$iAccount}{else}0{/if}/{if $fromDate}{$fromDate}{/if}/{if $toDate}{$toDate}{/if}">
                        <button type="button" class="btn btn-info btn-md">
                            Generovat PDF
                        </button>
                    </a>
                </div>
            </div>
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

<script>
  $(function() {
    $( "#datepicker" ).datepicker({ "dateFormat": "yy-mm-dd" });
  });
  $(function() {
    $( "#datepicker2" ).datepicker({ "dateFormat": "yy-mm-dd" });
  });
  </script>