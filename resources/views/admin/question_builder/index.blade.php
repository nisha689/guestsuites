@extends('admin.layouts.app')
@section('title', 'Question Builder | '.trans('admin.front_title'))
@section('stylesheet')
  <link type="text/css" rel="stylesheet" href="{{ url('common/css/toastr.min.css')}}">
  <link type="text/css" rel="stylesheet" href="{{ url('admin/css/style_temp.css')}}">
@endsection
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Question Builder</h1>
                        <div class="clear-both"></div>
                        <div id="serviceApp"><service-app></service-app></div>
                      <script type="text/x-template" id="serviceAppTemplate">
                        <div class="container-fluid mt-4">
                          <div class="card card-question-list mb-3" v-if="Object.keys(questions).length > 0">
                            <div class="card-header">
                              <span class="card-title">Questions</span>
                            </div>
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item" v-for="(questionItem,questionIndex) in questions" :key="questionIndex">
                                <span>@{{questionItem.question}}</span>
                                <button class="btn btn-sm btn-remove-question" @click="removeQuestion(questionItem)"><i class="fa fa-trash"></i></button>
                                <button class="btn btn-sm btn-link" @click="editQuestion(questionItem)"><i class="fa fa-pen"></i></button>
                              </li>
                            </ul>
                          </div>

                          <button type="button" class="btn btn-sm btn-primary" @click="getQuestions">Get Questions</button>

                          <div class="card card-question-add mb-2">
                            <div class="card-body d-flex pb-0">
                              <select v-model="serviceId" id="questionServiceModel" class="custom-select custom-select-sm mr-2" @change="subCategoryId = ''">
                                <option value="">Select service type</option>
                                <option v-for="(service,serviceIndex) in services" :key="serviceIndex" :value="service.business_service_id">@{{service.business_service_name}}</option>
                              </select>
                              <select v-model="subCategoryId" class="custom-select custom-select-sm" :disabled="serviceId == '' || ((serviceId != '') && (services[serviceId]['sub_category'].length == 0))">
                                <option value="">Select sub category</option>
                                <template v-if="serviceId != ''">
                                  <option v-for="(sub_category,sub_category_index) in services[serviceId]['sub_category']" :key="sub_category_index" :value="sub_category.service_category_id">
                                    @{{sub_category.service_category_name}}
                                  </option>
                                </template>
                              </select>
                            </div>
                            <div class="card-body d-flex">
                              <span class="question-type-icon" :class="{[typeOfQuestion]:true}"></span>
                              <select v-model="typeOfQuestion" class="custom-select custom-select-sm" @change="updateQuestionSelection">
                                <option v-for="(queType,queTypeIndex) in question_types" :key="queTypeIndex" :value="queType.id">@{{queType.label}}</option>
                              </select>
                              <button class="btn btn-sm btn-primary" :disabled="typeOfQuestion == ''" @click="addNewQuestion()">+ Add Question</button>
                            </div>

                            
                            <div class="card-body d-flex question-card" :class="{['card_'+questionModel.type]:true}" v-if="Object.keys(questionModel).length > 0">
                              <textarea class="form-control" placeholder="Enter your question here..." v-model="questionModel.question"></textarea>

                              <template v-if="(questionModel.type == 'radio_options') || (questionModel.type == 'check_options') || (questionModel.type == 'image_options')">
                                <div class="option-list-wrap">
                                  <label>Question Options</label>
                                  <div class="option-list" v-if="questionModel.options.length > 0">
                                    <span v-for="(option,optionIndex) in questionModel.options" :id="option.o_id" :key="optionIndex" :title="option.label"
                                      :class="{
                                        'image-badge':(questionModel.type == 'image_options'), 
                                        'badge':!(questionModel.type == 'image_options'),
                                        'check-badge': (questionModel.type == 'check_options'),
                                        'radio-badge': (questionModel.type == 'radio_options'),
                                      }"
                                      > 
                                      <span class="option-img" v-if="(questionModel.type == 'image_options')">
                                        <img :src="option.img_path" :alt="option.label">
                                      </span>
                                      <span class="option-label">@{{option.label}}</span>
                                      <button type="button" class="btn btn-danger btn-sm btn-remove-option" @click="removeOption(option)"><i class="fa fa-times"></i></button>
                                    </span>
                                  </div>
                                  <div class="d-flex w-100 mt-2">
                                    <input type="file" v-if="(questionModel.type == 'image_options')" accept="image/*" id="optionImage" class="form-control form-control-sm mr-1" v-model="questionModel.optionImgModel">
                                    <input type="text" class="form-control form-control-sm mr-2" placeholder="Enter option text.." v-model="questionModel.optionModel" @keyup.enter="addOption">
                                    <button class="btn btn-sm btn-success mt-0" :disabled="((questionModel.optionModel == ''))" @click="addOption">ADD</button>    
                                  </div>
                                </div>
                              </template>

                              <button class="btn btn-sm btn-danger" :class="{'ml-0':((questionModel.type == 'radio_options') || (questionModel.type == 'check_options') || (questionModel.type == 'image_options'))}" @click="cancelQuestion">Cancel</button>
                              <button class="btn btn-sm btn-primary " :disabled="questionModel.question == ''" @click="saveQuestion">Save</button>
                            </div>
                          </div>
                        </div>
                      </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    
    <script type="text/javascript" src="{{url('common/js/sweetalert.min.js')}}"></script>
    <script type="text/javascript" src="{{url('common/js/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{url('common/js/axios.min.js')}}"></script>
    <script type="text/javascript" src="{{url('common/js/vue.min.js')}}"></script>
    {{-- <script type="text/javascript" src="{{url('common/js/app.service.js')}}"></script> --}}
    <script type="text/javascript">
   
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
      mounted:function(){
        
      }
});

new Vue({
  el: "#serviceApp",
  components:['serviceApp'],
  data:{},
  methods: {},
  mounted: function() {

  }
});
    </script>

@endsection
