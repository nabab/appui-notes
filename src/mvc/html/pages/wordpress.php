<bbn-table class="bbn-h-100"
           ref="table"
           :source="root + 'pages/wordpress'"
           :limit="25"
           :info="true"
           :pageable="true"
           :sortable="true"
           :selection="true"
           :filterable="true"
>
  <bbns-column field="ID"
               title="<?=_("ID")?>"               
               cls="bbn-c"
               :width="50"
  ></bbns-column>

  <bbns-column field="post_type"
               title="<?=_("Post Type")?>"               
               cls="bbn-c"
  ></bbns-column>
 
  <bbns-column field="post_name"
               title="<?=_("Post Name")?>"               
               cls="bbn-c"
  ></bbns-column>

  <bbns-column field="url"
               title="<?=_("Page url")?>"               
               :render="renderUrl"
               :width="300"
               cls="bbn-c"
  ></bbns-column>

  <bbns-column field="post_title"
               title="<?=_("Post title")?>"
  ></bbns-column>

  <bbns-column field="post_content"
               title="<?=_("Post Content")?>"               
               :width="300"
               :filterable="false"
  ></bbns-column>

  <bbns-column field="display_name"
               title="<?=_("Author")?>"                              
  ></bbns-column>

  <bbns-column field="post_date"
               title="<?=_("Date")?>"
               type="datetime"
               :render="renderDate"
              
  ></bbns-column>
  <bbns-column field="post_date_gmt"
               title="<?=_("Date GMT")?>"
               type="datetime"
               :render="renderDateGmt"
               
  ></bbns-column>

  <bbns-column field="post_modified"
               title="<?=_("Post modified")?>"
               type="datetime"
               :render="renderDateModified"
              
  ></bbns-column>
  
  <bbns-column field="post_status"
               title="<?=_("Post Status")?>"
               cls="bbn-c" 
  ></bbns-column>
 
</bbn-table>

