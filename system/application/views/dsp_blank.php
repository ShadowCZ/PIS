<header class="navbar navbar-default" role="navigation">    
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="active">
                <h3>
                    Důvěryhodná banka
                </h3>
            </li>
        </ul>
       
        <ul class="nav navbar-nav navbar-right">
            <li>
                <h3> Kája Mařík </h3>
            </li>
             <li>
                {anchor uri="cmain/logout/" label="Odhlášení"}
            </li>
        </ul>
    </div>
</header>
<content class="row clearfix">
    <div class="col-md-3 column">
        <ul class="nav nav-stacked nav-pills">
            <li class="active">
                <a href="#">Zaměstnanci</a>
            </li>
            <li>
                <a href="#">Účty</a>
            </li>
            <li>
                <a href="#">Klienti</a>
            </li>
            <li>
                <a href="#">Transakce</a>
            </li>
            <li>
                <a href="#">**Messages</a>
            </li>
            <li>
                <a href="#">**Messages</a>
            </li>
            
        </ul>
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
                <space></space>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Product
                            </th>
                            <th>
                                Payment Taken
                            </th>
                            <th>
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                1
                            </td>
                            <td>
                                TB - Monthly
                            </td>
                            <td>
                                01/04/2012
                            </td>
                            <td>
                                Default
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                1
                            </td>
                            <td>
                                TB - Monthly
                            </td>
                            <td>
                                01/04/2012
                            </td>
                            <td>
                                Approved
                            </td>
                        </tr>
                        <tr class="success">
                            <td>
                                2
                            </td>
                            <td>
                                TB - Monthly
                            </td>
                            <td>
                                02/04/2012
                            </td>
                            <td>
                                Declined
                            </td>
                        </tr>
                        <tr class="warning">
                            <td>
                                3
                            </td>
                            <td>
                                TB - Monthly
                            </td>
                            <td>
                                03/04/2012
                            </td>
                            <td>
                                Pending
                            </td>
                        </tr>
                        <tr class="danger">
                            <td>
                                4
                            </td>
                            <td>
                                TB - Monthly
                            </td>
                            <td>
                                04/04/2012
                            </td>
                            <td>
                                Call in to confirm
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            </div>
<!--                         <div class="panel-footer">
                Panel footer
            </div> -->
        </div>
        
        
    </div>
</content>
