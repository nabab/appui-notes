<div class="bbn-full-screen">
  <bbn-list style="height:70%" :source="currentFolder" @click="selectList" @select="selectList">

  </bbn-list>

   <appui-notes-bookmarks-show v-if="showLink"
                               :source="showLink"
                               :style="topContent ? 'top:0' : 'bottom:0'"
   >
  </appui-notes-bookmarks-show>
</div>