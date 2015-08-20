class AddMainImageToPosts < ActiveRecord::Migration
  def change
    add_column :posts, :main_image, :string
  end
end
