
var app = angular.module('myApp', []);

app.controller('myCtrl', function($scope,$http) {
    //$scope.keyward= "June";
    $scope.custList=[];
    $scope.menu=[];
    $scope.menu_c=[];
    $scope.customer={cNo:0,cName:"",cPhone:""};
    $scope.items=[];
    $scope.total=0;
    $scope.totalCnt=0;
    $scope.paid=false;
    $scope.regCust={fName:"",lName:"",pNo:""};
    $scope.recent=[];

    $scope.showCust=function(){
        $http.get("cust.json.php?q="+$scope.keyward).then(function (response) {
            $scope.custList = response.data;
        });
    }

    $scope.menuF=function(){
        $http.get("menu.php").then(function (response) {
            $scope.menu = response.data;
        });
    }

    $scope.menu_cF=function(){
        $http.get("menu_c.php").then(function (response) {
            $scope.menu_c = response.data;
        });
    }

    $scope.selCust=function(no,name,phone){
        $scope.customer.cNo=no;
        $scope.customer.cName=name;
        $scope.customer.cPhone=phone;
        
        $scope.custList=[];
        $scope.getRecent();
    }

    $scope.addItem=function(id,name,price){
        let itm={};
        itm.id=id;
        itm.name=name;
        itm.price=price;
        itm.cnt=1;
        $scope.items.push(itm);

        $scope.calTotal();
    }

    $scope.delItem=function(id,idx){
        $scope.items.splice(idx, 1); 
        $scope.calTotal();
    }

    $scope.clearItems=function(){
        $scope.items=[];
        $scope.calTotal();
    }

    $scope.getRecent=function(){
        $http.get("recent.php?cNo="+$scope.customer.cNo)
        .then(function(response){
            $scope.recent=response.data;
            
        });
        
    }

    $scope.addCount=function(id,idx){
        $scope.items[idx].cnt+=1;
        $scope.calTotal();
    }
    $scope.subCount=function(id,idx){
        $scope.items[idx].cnt-=1;
        $scope.calTotal();
    }
    $scope.register=function(){
        $http.get("regCust.php?fName="+$scope.regCust.fName+"&lName="+$scope.regCust.lName+"&pNo="+$scope.regCust.pNo)
        .then(function(response){
            let answer=response.data;
            
            $scope.selCust(answer.lastId, $scope.regCust.fName + " " + $scope.regCust.lName, $scope.regCust.pNo);
        });
    }

    $scope.calTotal=function(){
        let total=0;
        let cnt=0;

        for(let i=0;i<$scope.items.length;i++){
            total += $scope.items[i].price * $scope.items[i].cnt;
            cnt += $scope.items[i].cnt;
        }
        $scope.total=total;
        $scope.totalCnt=cnt;
    }

    $scope.checkOut=function(){
        if(!$scope.customer.cNo){
            alert("Choose Customer!");
            return;
        }


        if(!$scope.totalCnt){
            alert("No items");
            return;
        }
        //serialize $scope.items[], $scope.customer.cNo
        $http.get("checkout.php?cNo="+$scope.customer.cNo+"&paid="+$scope.paid+"&items="+JSON.stringify($scope.items))
        .then(function(response){
            //clear checkout list
            
            //alert("Printing = ".response);
            $scope.clearItems();    
            
            if (confirm("Do you want 1 more copy?")) {
                //printFile?filename=response.data.file
                $http.get("printfile.php?last_id="+response.data.last_id);
            }

        });

    }

    $scope.delTrans=function(tNo){
        
        if (window.confirm("R U Sure Delete?")) {
            //deleting code

            $http.get("delTrans.php?tNo="+tNo)
            .then(function(response){
                //clear checkout list

                $scope.getRecent();
    
            });

        }
    }



    $scope.updateTrans=function(tNo,act){
        $http.get("updateTrans.php?tNo="+tNo+"&act="+act)
        .then(function(response){
            //clear checkout list

            $scope.getRecent();

        });

    }
    
    $scope.menuF();
    $scope.menu_cF();


});