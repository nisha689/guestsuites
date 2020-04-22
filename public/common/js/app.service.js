Vue.component('serviceApp', {
  template:'#serviceAppTemplate',
  components:[],  
  props:[],
  data() {
    return {
      questions:{},
      question_types:[
        { id:'text', label:'Text' },
        { id:'yes_no', label:'Yes or No' },
        { id:'date', label:'Date' },
        { id:'radio_options', label:'Radio Options' },
        { id:'check_options', label:'Checkbox Options' },
        { id:'image_options', label:'Image Options' }
      ],
      services:{
        "1": { "business_service_id": 1, "business_service_name": "Massage", "business_service_icon": "http://127.0.0.1/guestsuites/trunk/public/images/service/profile1_15875353871387492807.jpg",
          "sub_category": {
            "1": { "service_category_id": 1, "business_service_id": 1, "service_category_name": "Area of pain" },
            "2": { "service_category_id": 2, "business_service_id": 1, "service_category_name": "Consensual areas" },
            "3": { "service_category_id": 3, "business_service_id": 1, "service_category_name": "Day to day" },
            "4": { "service_category_id": 4, "business_service_id": 1, "service_category_name": "Lifestyle" },
            "5": { "service_category_id": 5, "business_service_id": 1, "service_category_name": "History" },
            "6": { "service_category_id": 6, "business_service_id": 1, "service_category_name": "Consent" }
          }
        },
        "2": { "business_service_id": 2, "business_service_name": "Facial", "business_service_icon": "", "sub_category": [] },
        "3": { "business_service_id": 3, "business_service_name": "Hair from", "business_service_icon": "", "sub_category": []},
        "4": { "business_service_id": 4, "business_service_name": "Eye lashes", "business_service_icon": "", "sub_category": [] },
        "5": { "business_service_id": 5, "business_service_name": "Hair removal", "business_service_icon": "", "sub_category": [] }
      },
      serviceId:'',
      subCategoryId:'',
      typeOfQuestion:'text',
      questionModel:{},
      edit_mode:false,
    }
  },
  methods: {
    ID:function (prefix) {
      var prefix = (typeof prefix == 'string') ? prefix+'_' : '';
      return prefix + Math.random().toString(36).substr(2, 9);
    },
    cloneJson:function(json){
      return JSON.parse(JSON.stringify(json));
    },
    addNewQuestion:function(){
      var vm = this;
      var questionId = vm.ID('question');
      var questionObj = {};
          questionObj['type'] = vm.typeOfQuestion;
          questionObj['question_id'] = '';
          questionObj['q_id'] = questionId;
          questionObj['question'] = '';
          questionObj['business_service_id'] = '';
          questionObj['service_category_id'] = '';

      if(
        (questionObj['type'] == 'radio_options') || 
        (questionObj['type'] == 'check_options') ||
        (questionObj['type'] == 'image_options')
      ){
        questionObj['options'] = [];
        questionObj['optionModel'] = '';
        if(questionObj['type'] == 'image_options'){
          questionObj['optionImgModel'] = ''; 
        }
      }

      if(
          (Object.keys(vm.questionModel).length > 0) && 
          (vm.questionModel.question != '' || 
          (vm.questionModel.hasOwnProperty('options') && 
          (vm.questionModel['options'].length > 0)))
        ){
        swal({
          title: "Are you sure?",
          text: "Current question will be remove!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            vm.questionModel = questionObj;
          }
        });
      }else{
        vm.questionModel = questionObj;
      }
    },
    saveQuestion:function(){
      var vm = this;
      var queationIndex = vm.questionModel.q_id;
      if((vm.questionModel.type.indexOf('options')>=0) && (vm.questionModel.options.length == 0)){
        toastr.error('Question with options should have atleast 1 option.', 'Opps!')
        return;
      }
      if(vm.serviceId == ''){
        toastr.error('Select any service', 'Opps!');
        $('#questionServiceModel').trigger('focus');
        return;
      }
      
      vm.questionModel['business_service_id'] = vm.serviceId;
      vm.questionModel['service_category_id'] = vm.subCategoryId;

      vm.questions[queationIndex] = vm.questionModel;
      vm.questionModel = {};
      vm.edit_mode = false;
      vm.addNewQuestion();
    },
    cancelQuestion:function(){
      var vm = this;
      if(vm.questionModel.question != '' || (vm.questionModel.hasOwnProperty('options') && vm.questionModel['options'].length > 0)){
        swal({
          title: "Are you sure?",
          text: "Your question will be removed!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            vm.questionModel = {};
            vm.edit_mode = false;
          }
        });
      }else{
        vm.questionModel = {};
        vm.edit_mode = false;
      }
      
    },
    editQuestion:function(questionItem){
      var vm = this;
      vm.edit_mode = true;
      var questionObj = vm.cloneJson(questionItem);

      vm.typeOfQuestion = questionObj.type;

      if(questionObj.hasOwnProperty('optionModel')){
        questionObj['optionModel'] = '';
      }
      if(questionObj.hasOwnProperty('optionImgModel')){
        questionObj['optionImgModel'] = '';
      }

      vm.serviceId = questionObj['business_service_id'];
      vm.subCategoryId = questionObj['service_category_id'];

      vm.questionModel = questionObj;
    },
    removeQuestion:function(questionItem){
      var vm = this;
      function remove(){
        console.log(questionItem);
      }
      swal({
        title: "Are you sure?",
        text: "Your question will be removed from database and never recoverd.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          remove();
        }
      });      
    },
    updateQuestionSelection:function(){
      var vm = this;
      vm.questionModel = {};
    },
    addOption:function(){
      var vm = this;
      var optionObj = {};
      var optionId = vm.ID('option');
      optionObj['label'] = vm.questionModel['optionModel'];
      optionObj['o_id'] = optionId;
      optionObj['option_id'] = '';
      if(vm.questionModel['type'] == 'image_options'){
        if(vm.questionModel['optionImgModel'] == ''){
          toastr.error('Select image for option.', 'Image not found..');
          $('#optionImage').focus();
          return;
        }
        vm.getFile(function(pathObj){
          optionObj['img_path'] = pathObj.path;
          optionObj['icon'] = pathObj.files;
          vm.questionModel['options'].push(optionObj);
          vm.questionModel['optionModel'] = '';
          vm.questionModel['optionImgModel'] = ''
        });
      }else{
        vm.questionModel['options'].push(optionObj);
        vm.questionModel['optionModel'] = '';
      }
      
    },
    removeOption:function(option){
      var vm = this;
      var qId = vm.questionModel.q_id;
      vm.questionModel.options.splice(
        vm.questionModel.options.indexOf(option),1
      );
    },
    getFile:function(callback){
      var evt = document.getElementById('optionImage');
      var files = evt.files,
          path='';
        // FileReader support
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
              path = fr.result;
              callback({
                path:path,
                files:files
              });
            }
            fr.readAsDataURL(files[0]);
        }
        else {}

        return path;
    },

    getQuestions:function(){
      console.log(JSON.stringify(this.questions));
    }

  },
  mounted:function(){}
});

new Vue({
  el: "#serviceApp",
  components:['serviceApp'],
  data:{},
  methods: {},
  mounted: function() {}
});