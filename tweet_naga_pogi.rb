# encoding: utf-8

require 'mecab'
require 'csv'

#dic = File.read('pn_ja.dic', :encoding => Encoding::SJIS)
dic = File.read('pn_ja.dic')
*poji_nega = dic.lines.map { |line| line.chomp.split(':') }

result_word_file =  File.open("result_word.csv", "w")


poji_nega_hash = Hash.new
poji_nega.each do |poji_nega_row|
  poji_nega_hash[poji_nega_row[0]] = poji_nega_row[3]
end

item = Hash.new

CSV.foreach("sample_tweet.csv") do |row|
  node = MeCab::Tagger.new.parseToNode(row[1])
  pn_points = []
  while node
    word = node.feature.split(",")[6]
    if(poji_nega_hash[word] != nil) then
p      pn_points.push poji_nega_hash[word].to_f
    end
    puts "#{node.surface}\t#{node.feature}"
    node = node.next
  end

  # 平均値作成
  average_pn_point = pn_points.inject(0.0){|r,i| r+=i } / pn_points.size

  result_string = row[0] + "," +
      average_pn_point.to_s + "," +
      row[1] + "\n"
#  p result_string
  result_word_file.write(result_string)
  item[row[0]] ||= 0.0
  item[row[0]] += average_pn_point
end

CSV.open("result_item.csv", "wb") do |csv|
  item.sort {|(k1, v1), (k2, v2)| v2 <=> v1 }.each {|elem| csv << elem}
end


