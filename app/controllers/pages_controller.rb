class PagesController < ApplicationController

  
  def about
    @page_title = "About"
  end
  
  def contact
    @page_title = "Contact"
  end
  
  def landing_page
    @disable_nav = true
  end
  
  
end
