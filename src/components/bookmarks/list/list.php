<div class="bbn-overlay">
  <bbn-list style="height:70%" :source="currentFolder" @click="selectList" @select="selectList">

  </bbn-list>

   <appui-note-bookmarks-show v-if="showLink"
                               :source="showLink"
                               :style="topContent ? 'top:0' : 'bottom:0'"
   >
  </appui-note-bookmarks-show>
</div>