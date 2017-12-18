<!-- HTML Document -->

<bbn-table :source="source.data"
           class="appui-notes-masks-table"
           editable="popup"
           ref="table"
           :url="source.root + 'actions/mask/update'"
           :order="[{text:'ASC'}]"
           :groupable="true"
           :group-by="3"
           >
  <bbn-column :title="_('ID')"
              field="id_note"
              :width="100"
              :hidden="true"
              :editable="false"
              ></bbn-column>
  <bbn-column :title="_('Défaut')"
              field="default"
              cls="bbn-c"
              :width="50"
              :component="$options.components.def"
              :editable="false"
              ></bbn-column>
  <bbn-column :title="_('Version')"
              field="version"
              type="number"
              :width="50"
              :editable="false"
              ></bbn-column>
  <bbn-column :title="_('Type de lettre')"
              field="id_type"
              :editable="false"
              :component="$options.components.cat"
              ></bbn-column>
  <bbn-column :title="_('Objet')"
              field="title"
              ></bbn-column>
  <bbn-column :title="_('Dern. modif.')"
              field="creation"
              :editable="false"
              type="date"
              :width="120"
              ></bbn-column>
  <bbn-column :title="_('Utilisateur')"
              field="id_user"
              :editable="false"
              :width="150"
              :render="renderUser"
              ></bbn-column>
  <bbn-column :title="_('Texte')"
              field="content"
              editor="bbn-rte"
              :hidden="true"
              ></bbn-column>
  <bbn-column width='160'
              :title="_('Actions')"
              :buttons="getButtons"></bbn-column>

</bbn-table>