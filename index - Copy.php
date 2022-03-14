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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/js/angular.min.js"></script>
    </head>
    <body ng-app="myApp" ng-controller="myCtrl">
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">SuperChois's</a>
                <div ng-show="customer.cNo" class="alert alert-primary" role="alert">
                Customer : {{customer.cName}} ({{customer.cPhone}})
                </div>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#register">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-3">
                        <div class="text-center my-5">
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" ng-model="keyward" placeholder="Name or Number">
                                    <button class="btn btn-primary btn-lg px-4 me-sm-3" ng-click="showCust()">Search!</button>
                                </div>
                            </div>                            
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center text-light">
                                <div class="col-sm2" ng-repeat="c in custList">
                                    <button class="btn btn-primary" ng-bind="c.name" ng-click="selCust(c.no,c.name,c.phone)"></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Menu section-->
        <section class="py-5 border-bottom" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">

                    <div class="col-sm-3 mb-5 mb-lg-0" ng-repeat="m in menu">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3" ng-click="addItem(m.id,m.name,m.price)"><i class="bi bi-collection"></i></div>
                        <h3 class="h4 fw-bolder" ng-bind="m.name"></h3>
                        <p ng-bind="m.price|currency"></p>
                    </div>

                </div>
            </div>
        </section>
        <!-- Receipt section-->
        <section class="bg-light py-5 border-bottom">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder"  ng-bind="customer.cName+' ('+customer.cNo+')'"></h2>
                    <p class="lead mb-0"></p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <!-- Receipt List -->
                    <div class="col-lg-6 col-xl-4">
                        <div class="card mb-5 mb-xl-0">
                            <div class="card-body p-5">
                                <div class="small text-uppercase fw-bold text-muted" ng-hide="paid" ng-click="paid=!paid">Unpaid</div>
                                <div class="small text-uppercase fw-bold text-danger" ng-show="paid" ng-click="paid=!paid">Paid</div>
                                <div class="mb-3">
                                    <span class="display-4 fw-bold" ng-bind="total|currency"></span>
                                    <span class="text-muted"> / {{totalCnt}} items</span>
                                </div>
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2" ng-repeat="i in items">
                                    <i class="bi bi-x-square text-primary" ng-click="delItem(i.id,$index)"></i>
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
                                <div class="d-grid"><button class="btn btn-outline-primary" ng-click="checkOut()">Check Out!</button></div>
                            </div>
                        </div>
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

    </body>
</html>
