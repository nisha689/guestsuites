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
      services:{},
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
    addToObject:function (obj, key, value, index) {
		var temp = {};
		var i = 0;
		
		for (var prop in obj) {
			if (obj.hasOwnProperty(prop)) {
				if (i === index && key && value) {
					temp[key] = value;
				}

				temp[prop] = obj[prop];
				i++;
			}
		}

		
		if (!index && key && value) {
			temp[key] = value;
		}

		return temp;
	},
    addNewQuestion:function(){
      var vm = this;
      var questionId = vm.ID('question');
      var questionObj = {};
          questionObj['type'] = vm.typeOfQuestion;
          questionObj['question_id'] = '';
          questionObj['q_id'] = questionId;
          questionObj['label'] = '';
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
      var data = {};

      data['question_id']         = vm.questionModel['question_id'];
      data['service_category_id'] = vm.questionModel['service_category_id'];
      data['label']               = vm.questionModel['label'];
      data['type']                = vm.questionModel['type'];
      if(vm.questionModel.hasOwnProperty('options')){
        data['option'] = vm.questionModel['options'];
      }
      data['parent_question_id']  = 0;
      data['_token'] = window._token;

      axios.post(vm.saveQuestionUrl, data)
        .then(function (response) {
          var data = response['data'];
          if(data.success){
            vm.questionModel['question_id'] = data.question_id;
            if(vm.questionModel.hasOwnProperty('options')){
             vm.questionModel['options'].forEach(function(option){
                if(data.options.hasOwnProperty(option.o_id)){
                  option['option_id'] = data['options'][option.o_id];
                }
              });
            }
            if(vm.edit_mode){
            	vm.questions[queationIndex] = vm.questionModel;
            }else{
            	vm.questions = vm.addToObject(vm.questions,queationIndex, vm.questionModel, 0);

            }
            vm.questionModel = {};
            vm.edit_mode = false;
            vm.addNewQuestion();
            
          }
        }).catch(function(error){
          alert(error);
        })
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
    scrollToEditor:function(){
    	$('html, body').animate({
        	scrollTop: $("#question_editor").offset().top
    	}, 800);
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
      vm.scrollToEditor();
    },
    removeQuestion:function(questionItem){
      var vm = this;
      function remove(){
        var data = {};
        data['question_id']  = questionItem['question_id'];
        data['_token'] = window._token;
        
        axios.post(vm.removeQuestionUrl, data)
        .then(function (response) {
          var data = response['data'];
          if(data.success){
            if(vm.questions.hasOwnProperty(questionItem.q_id)){
              delete vm.questions[questionItem.q_id];
            }
            vm.$forceUpdate();
          }
        })
        .catch(function (error) { alert(error) });
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
          optionObj['image_url'] = pathObj.path;
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
  mounted:function(){
    this.services = window.services;
    this.questions = window.questions;
  },
  created:function(){
    this.saveQuestionUrl = window.baseURI+'/admin/question-builder/save_ajax';
    this.removeQuestionUrl = window.baseURI+'/admin/question-builder/delete';
  }
});

new Vue({
  el: "#serviceApp",
  components:['serviceApp'],
  data:{},
  methods: {},
  mounted: function() {}
});