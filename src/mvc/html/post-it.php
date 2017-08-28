<div class="bbn-h-100">
  <div class="bbn-w-100 bbn-block bbn-c bbn-vmargin" style="height: 80px">
    <input type="text" class="k-input k-textbox" placeholder="<?=_("Rechercher")?>" autocomplete="off" style="width: 75%; font-size: x-large">
  </div>
  <div class="bbn-w-100 bbn-block" v-bbn-fill-height>
    <div class="bbn-postit-container bbn-masonry" id="bbn-postit-container">
      <div class="bbn-widget" v-for="(note, index) in notes">
        <!--div class="k-header" v-text="myTitle(note)" >
        </div-->
        <!--
       div class="k-header" v-else v-text="no-title">

        </div-->
        <div class="bbn-lpadded">
          <div class="bbn-postit">
            <div style="position: absolute; right: 3px; bottom: 3px">
              <i class="bbn-p fa fa-edit" @click="editContent"> </i>
              <i class="bbn-p fa fa-cog" @click=""> </i>
            </div>
            <div>
              <div class="bbn-lg" v-text="myTitle(note)"></div>
              <div class="content" v-html="note.content"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
