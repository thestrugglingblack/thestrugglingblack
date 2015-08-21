class AddPostDescToPosts < ActiveRecord::Migration
  def change
    add_column :posts, :post_desc, :text
  end
end
