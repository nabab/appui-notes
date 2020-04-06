<div class="media-browser-context">
  <div :title="data.title"
       class="btn bbn-header media-el-btn"
       :style="data.is_image ? 'padding: 0' : ''"
       >
    <i v-if="!data.is_image && icons[data.content.extension] "
       :class="['bbn-xxxl',
               icons[data.content.extension] 
               ]">
    </i>
    <div v-if="!data.is_image && !icons[data.content.extension]"
         v-text="data.content.extension"
         class="bbn-large bbn-badge"
         style="margin-top:50%"
         >
    </div>
    <img v-else 
         @click="showImage(data)"
         class="media-img-preview"
				 :src="'notes/media/image/' + data.id"
				>
  </div>
  <div class="media-title">
    <div v-text="cutted"
         :title="data.title"
    ></div>
  </div>  
</div>