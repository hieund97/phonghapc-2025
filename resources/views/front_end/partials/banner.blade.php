<div class="fixed_banner">
  @if(isset($mainSettings['common_banner_4_status']) && $mainSettings['common_banner_4_status'] =='on')
   <div class="fixed-left">
     <a target="_blank" href="{{ $mainSettings['common_banner_4'] ?? '' }}">
       <img data-src="{{ $mainSettings['common_banner_3'] ?? '' }}" class="lazy w-auto h-auto loaded" width="1" height="1" src="{{ $mainSettings['common_banner_3'] ?? '' }}" data-was-processed="true">
     </a>
   </div>
  @endif
 
  @if(isset($mainSettings['common_banner_4_status']) && $mainSettings['common_banner_6_status'] =='on')
   <div class="fixed-right">
     <a target="_blank" href="{{ $mainSettings['common_banner_6'] ?? '' }}">
       <img data-src="{{ $mainSettings['common_banner_5'] ?? '' }}" class="lazy w-auto h-auto loaded" width="1" height="1" src="{{ $mainSettings['common_banner_5'] ?? '' }}" data-was-processed="true">
     </a>
   </div>
  @endif
</div>