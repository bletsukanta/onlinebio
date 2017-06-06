/*app.run(function($rootScope) {
    //$rootScope.contentdisplay = '';
})*/
app.controller('faqCtrl', function ($scope,$rootScope, $sce, $http, API_URL) {
    //$scope.showContent='true';
    $scope.TrustedHtml = function (snippet) {
        return $sce.trustAsHtml(snippet);
    };
});
app.controller('contentCtrl', function ($scope,$rootScope, $sce, $http, API_URL) {
    //$scope.showContent='true';
});
app.controller('homeCtrl', function ($scope, $rootScope,$sce, $http, API_URL) {
    
});
app.controller('footerCtrl', function ($scope,$rootScope,$sce,$http,API_URL) {
    $scope.getContent = function (contentid) {
        //alert(API_URL);//return false;
        //alert('selected content id' + contentid);
        $http({
            method: "POST",
            url: API_URL+"get-content",
            data: {"content_id": contentid}
        }).then(function (response) {
            console.log(response);
            //alert(response);return false;
            //alert(response.data[0].content_description);
            $rootScope.ContentTitle = response.data[0].content_title;
            $rootScope.ContentDescription = $sce.trustAsHtml(response.data[0].content_description);
            $rootScope.showFaq=true;
            $rootScope.showContent=false;
            $rootScope.showHome=true;
            //alert(JSON.stringify(response.data));
        }, function (response) {
            alert('Error occured' + response.statusText);
        });
    }
    //FOr showing subdomain name after category,domain_name,user_name field filledup
    $scope.getFaqs = function(){
       $http({
            method: "GET",
            url: API_URL+"get-faqs",
            data: {}
        }).then(function (response) {
            console.log(response);
            //alert(response);return false;
            //alert(response.data[0].content_description);
            $rootScope.faqArr = response.data;
            //$rootScope.ContentDescription = $sce.trustAsHtml(response.data[0].content_description);
            $rootScope.showFaq=false;
            $rootScope.showContent=true;
            $rootScope.showHome=true;
            //alert(JSON.stringify(response.data));
        }, function (response) {
            alert('Error occured' + response.statusText);
        }); 
    }
});
