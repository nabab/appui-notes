<div class="appui-h-100">
  <div class="appui-w-100 appui-block appui-c appui-vmargin" style="height: 80px">
    <input type="text" class="k-input k-textbox" placeholder="<?=_("Rechercher")?>" autocomplete="off" style="width: 75%; font-size: x-large">
  </div>
  <div class="appui-full-height appui-w-100 appui-block">
    <div class="appui-postit-container appui-masonry" id="appui-postit-container">
      <div class="appui-widget" v-for="(note, index) in notes">
        <!--div class="k-header" v-text="myTitle(note)" >
        </div-->
        <!--
       div class="k-header" v-else v-text="no-title">

        </div-->
        <div class="appui-lpadded">
          <div class="appui-postit">
            <div style="position: absolute; right: 3px; bottom: 3px">
              <i class="appui-p fa fa-edit" @click="editContent"> </i>
              <i class="appui-p fa fa-cog" @click=""> </i>
            </div>
            <div>
              <div class="appui-lg" v-text="myTitle(note)"></div>
              <div class="content" v-html="note.content"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
