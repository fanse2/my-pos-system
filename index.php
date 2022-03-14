<?php
require_once('dave.php');

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SuperChoi's</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        
        <!-- AniCollection.css library -->
        <link rel="stylesheet" href="https://anijs.github.io/lib/anicollection/anicollection.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/js/angular.min.js"></script>
        <!--script src="/anijs/anijs-min.js"></script--><script src="https://cdnjs.cloudflare.com/ajax/libs/AniJS/0.2.0/anijs-min.js" integrity="sha512-PuTHiMJ2HmOUKlotbb3/8PXhrSEtCpWeV9cmxT5P6vFHFXHkorWthu0LkySyYZSd66RpJyD8g6T6cU/8JsYE7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body ng-app="myApp" ng-controller="myCtrl">
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">SuperChois's</a>
                <div ng-show="customer.cNo" class="text-warning"><i class="bi bi-caret-right-fill text-warning"></i>  {{customer.cName}} ({{customer.cPhone}}) </div>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#" data-anijs="if: click, do: flipInY animated">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#register" data-anijs="if: click, do: flipInY animated">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="text-center my-2">
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" class="form-control mb-3" id="search" ng-model="keyward" placeholder="Name or Number" />
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-primary px-4 me-sm-3" ng-click="showCust()" data-anijs="if: click, do: flipInY animated">Search!</button>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-2 m-1" ng-repeat="c in custList">
                                <button class="btn btn-info" ng-bind="c.name" ng-click="selCust(c.no,c.name,c.phone)"  data-anijs="if:click, do: hinge animated, to: #c_name"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Menu section-->
        <section class="py-5 border-bottom" id="features" >
            <div class="container px-5 my-3">
                <div class="row">
                    <div class="row col-8">
                        <div class="col-sm-3 mb-5 mb-lg-0 text-center " ng-repeat="m in menu">
                            <img class="rounded" ng-click="addItem(m.id,m.name,m.price)" ng-src="/svc_icon/{{m.icon}}">
                            <h3 class="h4 fw-bolder" ng-bind="m.name"></h3>
                            <p ng-bind="m.price|currency"></p>
                        </div>
                    </div>

                    <div class="row pl-2 col-4">
                        
                        <!-- Receipt section-->

                        <div id='receipt' class="container px-1 my-2">
                            <div class="text-center mb-3">
                                <h2  data-anijs="if:click, do: hinge animated, to: #main" class="fw-bolder"  ng-bind="customer.cName+' ('+customer.cNo+')'"></h2>
                                <p class="lead mb-0"></p>
                            </div>
                            <div class="row gx-5 justify-content-center">
                                <!-- Receipt List -->
                                <div class="card mb-5 mb-xl-0">
                                    <div class="card-body p-1">
                                        <div class="text-uppercase fw-bold text-danger mt-3" ng-hide="paid" ng-click="paid=!paid">UnPaid</div>
                                        <div class="text-uppercase fw-bold text-success mt-3" ng-show="paid" ng-click="paid=!paid">[[ Paid ]]</div>
                                        <div class="mb-3">
                                            <span class="display-4 fw-bold" ng-bind="total|currency"></span>
                                            <span class="text-success"> / {{totalCnt}} items</span>
                                        </div>
                                        <ul class="list-unstyled mb-4">
                                            <li class="mb-2" ng-repeat="i in items">
                                            <i class="bi bi-x-square text-danger" ng-click="delItem(i.id,$index)"></i>
                                            {{i.name}} - 
                                            <i class="bi bi-plus-square text-primary" ng-click="addCount(i.id,$index)"></i> 
                                            {{i.cnt}}pc
                                            <i class="bi bi-dash-square text-primary" ng-click="subCount(i.id,$index)" ng-show="i.cnt > 1"></i> 
                                            <br>   
                                            
                                            <div class="row">
                                                <div class="col-3"><input type="text" ng-model="i.price" ng-change="calTotal()"></div>
                                                <div class="col-9">
                                                    <input type="text" ng-model="i.memo">
                                                </div>
                                            </div>
                                            </li>
                                        </ul>
                                        <div class="d-grid mb-3"><button data-anijs="if: click, do: flipInY animated" class="btn btn-outline-primary" ng-click="checkOut()">Check Out!</button></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-1 mt-2">
                                <h2 class="fw-bolder">Recent Order List</h2>
                            </div>
                            <div class="row gx-5 justify-content-center">
                                <ul class="list-group ">
                                    <li class="list-group-item" ng-repeat="r in recent">
                                        <i class="bi bi-x-square text-danger" ng-click="delTrans(r.cNo)"></i> {{r.drop_date}}  
                                        <i class="bi bi-file-arrow-up text-primary" ng-hide="r.pickedup=='y'" ng-click="updateTrans(r.cNo,'uy')"></i> 
                                        <i class="bi bi-file-arrow-up text-light" ng-show="r.pickedup=='y'" ng-click="updateTrans(r.cNo,'un')"></i> 
                                        {{r.t_amount| currency }}
                                        <i class="bi bi-check-all text-primary" ng-show="r.chk_paid=='y'" ng-click="updateTrans(r.cNo,'yn')"></i>
                                        <i class="bi bi-calculator text-danger" ng-hide="r.chk_paid=='y'" ng-click="updateTrans(r.cNo,'yy')"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /Receipt section-->
                        
                    </div>
                </div>
            </div>
        </section>

        <!-- Register section-->
        <section class="bg-light py-5" id="register">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder">Register</h2>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">


                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" ng-model="regCust.fName" required>
                                    <div class="invalid-feedback">
                                    Valid first name is required.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="" ng-model="regCust.lName" required>
                                    <div class="invalid-feedback">
                                    Valid last name is required.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Phone No</label>
                                    <input type="text" class="form-control" id="phoneNo" placeholder="" ng-model="regCust.pNo" required>
                                    <div class="invalid-feedback">
                                    Valid phone number is required.
                                    </div>
                                </div>
                            </div>


                            <hr class="mb-4">
                            <button class="btn btn-primary btn-lg btn-block" ng-click="register()">Register!</button>
                        </form>

                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-5"><p class="m-0 text-center text-white">Copyright &copy; SuperChoi's 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="myApp.js"></script>
        <!-- AniJS core library -->
        <script src="https://anijs.github.io/lib/anijs/anijs-min.js"></script> 

        <!-- Include to use $addClass, $toggleClass or $removeClass -->
        <script src="https://anijs.github.io/lib/anijs/helpers/dom/anijs-helper-dom-min.js"></script>

    </body>
</html>
