class Post < ActiveRecord::Base
  mount_uploader :main_image, MainImageUploader
end
