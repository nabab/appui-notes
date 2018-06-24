<div class="bbn-full-screen bbn-padded">
  <div class="bbn-flex-height">
    <div class="bbn-middle"
         style="padding-bottom: 1em"
    >
      <bbn-initial width="20"
                   height="20"
                   :user-id="source.id_user"
                   style="margin-right: 5px"
      ></bbn-initial>
      <span v-text="userName"></span>
      <span style="margin-left: 1em"><i class="fa fa-calendar"></i> {{creationDate}} <i class="far fa-clock"></i> {{creationTime}}</span>
    </div>
    <div class="bbn-flex-fill k-block">
      <bbn-scroll>
        <div class="bbn-padded"
             v-html="source.content"
        ></div>
      </bbn-scroll>
    </div>
  </div>
</div>