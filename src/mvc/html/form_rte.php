<bbn-form :source="source"
          ref="form"
          confirm-leave="<?=_("Are you sure you want to leave this form without saving your changes?")?>"
          action="/bbn/appui/notes/insert"
          :buttons="['submit']"
>
  <bbn-rte v-model="source.content"
           class="bbn-100"
  ></bbn-rte>
</bbn-form>