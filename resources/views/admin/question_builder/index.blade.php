@extends('admin.layouts.app')
@section('title', 'Question Builder | '.trans('admin.front_title'))
@section('stylesheet')
<link type="text/css" rel="stylesheet" href="{{ url('common/fonts/fontawesome/all.min.css')}}">
<link type="text/css" rel="stylesheet" href="{{ url('common/css/toastr.min.css')}}">
<link type="text/css" rel="stylesheet" href="{{ url('admin/css/style_question.css')}}">
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
          <h1 class="admin_bigheading mb-5">Question Builder</h1>
          <div class="clear-both"></div>
          <div id="serviceApp"><service-app></service-app></div>
          <script type="text/x-template" id="serviceAppTemplate">
            <div class="container-fluid mt-4">
                <div class="card card-question-list mb-3" v-if="Object.keys(questions).length > 0">
                  <div class="card-header">
                    <span class="card-title">Questions</span>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="(questionItem,questionIndex,questionNumber) in questions" :key="questionIndex"  :id="questionItem.q_id">
                      <span>@{{questionItem.label}}</span>
                      <button class="btn btn-sm btn-remove-question" @click="removeQuestion(questionItem)"><i class="fa fa-trash"></i></button>
                      <button class="btn btn-sm btn-link" @click="editQuestion(questionItem)"><i class="fa fa-pen"></i></button>
                    </li>
                  </ul>
                </div>

                {{-- <button type="button" class="btn btn-sm btn-primary" @click="getQuestions">Get Questions</button> --}}

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
                    <button class="btn btn-sm btn-primary" :disabled="typeOfQuestion == '' || serviceId == '' || subCategoryId == ''" @click="addNewQuestion()">+ Add Question</button>
                  </div>

                  
                  <div class="card-body d-flex question-card" :class="{['card_'+questionModel.type]:true}" v-if="Object.keys(questionModel).length > 0">
                    <textarea class="form-control" placeholder="Enter your question here..." v-model="questionModel.label"></textarea>

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
                              <img :src="option.image_url" :alt="option.label">
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
                    <button class="btn btn-sm btn-primary " :disabled="questionModel.label == ''" @click="saveQuestion">Save</button>
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

<script type="text/javascript">
window.services = "{{ json_encode($servicesWithCategory) }}";
window.services = JSON.parse(window.services.replace(/&quot;/g, '"'));

window.questions = "{{ json_encode($questionList) }}";
window.questions = JSON.parse(window.questions.replace(/&quot;/g, '"'));
</script>
<script type="text/javascript" src="{{url('common/js/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/axios.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/vue.min.js')}}"></script>
<script type="text/javascript" src="{{url('common/js/app.service.js')}}"></script>

@endsection