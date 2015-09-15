class Post < ActiveRecord::Base
  mount_uploader :main_image, MainImageUploader
  
  validates :title, :presence => true, :length => { :minimum => 5}
  validates :body, :presence => true, :length => { :minimum => 3}
  validates :post_desc, :presence => true
 
end
