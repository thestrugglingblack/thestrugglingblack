Rails.application.routes.draw do
  resources :posts
  devise_for :users

  root 'pages#landing_page'
  
  get 'pages/about'
  get 'pages/contact'
  
  match '/contacts',  to: 'contacts#new',   via: 'get'
  resources "contacts", only: [:new, :create]
  
end
