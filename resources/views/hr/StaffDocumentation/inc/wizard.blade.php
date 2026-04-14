<div class="wizard noprint" style="background: none; padding-right: 10px;">
    <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="{{$tabLevel1}}">
                    <a href="#" id="tab" role="tab" title="Court Info.">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-play"></i>
                        </span>
                    </a>
                </li>
                <li role="presentation"  class="{{$tabLevel2}}">
                    <a href="@if($progress > 5) {{route('getBasicInfo')}} @else # @endif" id="tab" role="tab" title="Basic">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </span>
                    </a>
                </li>
                <li role="presentation" class="{{$tabLevel3}}">
                     <a href="@if($progress > 6){{route('getContact')}} @else # @endif" id="tab" role="tab" title="Contact">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-phone-alt"></i>
                        </span>
                    </a>
                    
                </li>
                <li role="presentation" class="{{$tabLevel4}}">
                    <a href="@if($progress > 7){{route('getPlaceOfBirth')}} @else # @endif" id="tab" role="tab" title="State of Origin">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-globe"></i>
                        </span>
                    </a>
                </li>
                <li role="presentation" class="{{$tabLevel5}}">
                     <a href="@if($progress > 8){{route('getMarital')}} @else # @endif" id="tab" role="tab" title="Marriage">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-heart"></i>
                        </span>
                    </a>
                    
                </li>
                <li role="presentation" class="{{$tabLevel6}}">
                     <a href="@if($progress > 9){{route('getNextOfKin')}} @else # @endif" id="tab" role="tab" title="Next of kin">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                    </a>
                    
                </li>
                <li role="presentation" class="{{$tabLevel7}}">
                    <a href="@if($progress > 10){{route('getChildren')}} @else # @endif" id="tab" role="tab" title="Children">
                        <span class="round-tab">
                            <i class="fa fa-child" aria-hidden="true"></i> 
                        </span>
                    </a>
                
                    
                </li>
                <li role="presentation" class="{{$tabLevel8}}">
                	<a href="@if($progress > 11){{route('getPrevEmployment')}} @else # @endif" id="tab" role="tab" title="Previous Employment">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-briefcase"></i>
                            </span>
                        </a>
                    
                </li>
                <li role="presentation" class="{{$tabLevel9}}">
                	<a href="@if($progress > 12){{route('getAttachment')}} @else # @endif" id="tab" role="tab" title="Attachment">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-file"></i>
                            </span>
                        </a>
                    
                </li>
                <li role="presentation" class="{{$tabLevel10}}">
                    <a href="@if($progress > 13){{route('getAccount')}} @else # @endif" id="tab" role="tab" title="Account">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-piggy-bank"></i>
                        </span>
                    </a>
                </li>
                <li role="presentation" class="{{$tabLevel11}}">
                    <a href="@if($progress > 14){{route('getOthers')}} @else # @endif" id="tab" role="tab" title="others">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-cloud"></i>
                        </span>
                    </a>
                 </li>
                 <li role="presentation" class="{{$tabLevel12}}">
                    <a href="@if($progress > 15){{route('getPreview')}} @else # @endif" id="tab" role="tab" title="preview">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-ok"></i>
                        </span>
                    </a>
                 </li>      
            </ul>
        </div>
    </div>