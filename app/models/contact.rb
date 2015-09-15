class Contact < MailForm::Base
  attribute :name,      :validate => true
  attribute :email,     :validate => /\A([\w\.%\+\-]+)@([\w\-]+\.)+([\w]{2,})\z/i
  attribute :subject,   :validate => true
  attribute :message
  attribute :nickname,  :captcha  => true
  
  validates :name, :presence => true
  validates :email, :presence => true
  validates :subject, :presence => true
  validates :message, :presence => true

  # Declare the e-mail headers. It accepts anything the mail method
  # in ActionMailer accepts.
  def headers
    {
      :subject => "The Struggling Black",
      :to => "zurihunter92@gmail.com",
      :from => %("#{name}" <#{email}>)
    }
  end
  
end
