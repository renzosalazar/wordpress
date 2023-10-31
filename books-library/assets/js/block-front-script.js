jQuery(document).ready(function ($) {
    $('body').on('change','.nls-parent-term .nls-child-term input[type="checkbox"]', function () {
          var selected_author = '';
          var selected_publisher = '';
          $('.book-author-filters .nls-parent-term .nls-child-term input:checkbox:checked').each(function (indexInArray, valueOfElement) { 
               selected_author += $(this).val() + '-';
          });
          $('.book-publisher-filters .nls-parent-term .nls-child-term input:checkbox:checked').each(function (indexInArray, valueOfElement) { 
               selected_publisher += $(this).val() + '-';
          });
          selected_author = selected_author.slice(0, -1); 
          selected_publisher = selected_publisher.slice(0, -1);
          var nls_book_authors_attr = $("#nls-book-authors").attr('name'); 
          var nls_book_publisher_attr = $("#nls-book-publisher").attr('name'); 
          if(selected_author == '' ){
               $("#nls-book-authors").removeAttr('name');
          }else{
               $("#nls-book-authors").attr('name', nls_book_authors_attr);
               $("#nls-book-authors").val(selected_author);
          }
          if( selected_publisher == '' ){
               console.log("happened");
               $('#nls-book-publisher').removeAttr('name'); 
          }else{
               $("#nls-book-publisher").attr('name', nls_book_publisher_attr);
               $('#nls-book-publisher').val(selected_publisher);
          }
          if( selected_author != '' || selected_publisher != '' )
               $('#nls_option_post_form').submit();
          else
               window.location.href = window.location.href.split('?')[0];
    });
    $('body').on('click','.nls-ajax-load-more-btn button', function () {
          var this_btn = $(this);
          $('.nls-loading-image').show();
          $(this_btn).hide();
          var selected_author, selected_publisher, nls_next_page_number,and_or_condition, posts_count, max_pages;
          max_pages = $('#nls_max_number_pages').val(); 
          selected_author = $('#nls-book-authors').val();
          selected_publisher = $('#nls-book-publisher').val();
          nls_next_page_number = $('#nls_next_page_number').val();
          and_or_condition = $('#nls_and_or_condition').val();
          posts_count = $("#nls_posts_per_page").val();
          var posting_data = {
               author              : selected_author,
               publishers          : selected_publisher,
               no_of_counts        : posts_count,
               and_or_condition    : and_or_condition,
               next_page_no        : nls_next_page_number,
               action              : 'nls_load_more_books'
          }
          console.log( posting_data );
          $.ajax({
               type: "post",
               url: frontend_ajax.ajax_url,
               data: posting_data,
               dataType: 'json',
               success: function (response) {
                    $('.nls_books_listing ').append(response.html_text);
               },
               complete: function (data) {
                    $('.nls-loading-image').hide();
                    $('#nls_next_page_number').val( ++nls_next_page_number );
                    if( max_pages >= nls_next_page_number ) $(this_btn).show();
               }
          });
    });
});