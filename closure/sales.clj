(ns sales
  (:require [clojure.java.io :as io]))
(use 'clojure.java.io)

(defstruct Customer :name :address :phoneNumber)
(with-open [rdr (reader "cust.txt")]
  (def custList (sorted-map ))
  (doseq [line (line-seq rdr)]

    (def  itemVector (clojure.string/split line #"\|"))


    (def cust (struct-map Customer
      :name (nth itemVector 1)
      :address (nth itemVector 2)
      :phoneNumber (nth itemVector 3)
      ))
    (def custList (assoc custList (nth itemVector 0) cust))

    ))

(defstruct Product :item :cost)
(with-open [rdr (reader "prod.txt")]
  (def prodList (sorted-map))
  (doseq [line (line-seq rdr)]
  (def provector (clojure.string/split line #"\|"))
  (def prod (struct-map Product
    :item (nth provector 1)
    :cost (nth provector 2)
    ))
    (def prodList (assoc prodList (nth provector 0) prod))
  ))

(defstruct sales :cID :proID :itemcount)
  (with-open [rdr (reader "sales.txt")]
    (def saleList (sorted-map))
    (doseq [line (line-seq rdr)]
    (def salesvector (clojure.string/split line #"\|"))
    (def s (struct-map sales
      :cID (nth salesvector 1)
      :proID (nth salesvector 2)
      :itemcount (nth salesvector 3)
      :custname (get (get custList (nth salesvector 1)) :name)
      :prodname (get (get prodList (nth salesvector 2)) :item)
      :itemcost (get (get prodList (nth salesvector 2)) :cost)
      ))
      (def saleList (assoc saleList (nth salesvector 0) s))

    ))



(while true
  (do
    (println "*** Sales Menu *** ")
    (println "------------------")
    (println)
    (println "1. Display Customer Table")
    (println "2. Display Product Table")
    (println "3. Display Sales Table")
    (println "4. Total Sales for Customer")
    (println "5. Total Count for Product")
    (println "6. Exit")
    (println "Enter option> ")
    (def x  (read-line))

  
  (case x "1" (doseq [n (keys custList)]
   (print n)
  (print ":[\"")
   (print (str (get (get custList n) :name)" " (get (get custList n) :address)" " (get (get custList n) :phoneNumber) ))
   (println "]")

  )
  "2" (doseq [n (keys prodList)]
   (print n)
  (print ":[\"")
   (print (str (get (get prodList n) :item)" " (get (get prodList n) :cost) ))
   (println "]")
  ;"6" (System/exit 0)
  )
  "3" (doseq [n (keys saleList)]

  (print n)
  (print ":[\"")
  (print (str (get (get saleList n) :custname)" " (get (get saleList n) :prodname)" " (get (get saleList n) :itemcount) ))
  (println "]")
  )
  "4" (do
    (def inputname (read-line))
    (def ^:dynamic sum 0.00)

    (doseq [n (keys saleList)]

    (if (= inputname (get (get saleList n) :custname))
    (do
      (def multi (* (Integer/parseInt (get (get saleList n) :itemcount))
      (Float/parseFloat (get (get saleList n) :itemcost)) ))
      (def sum (+ sum multi ))

    )
  ;  (def sum 0.00)

    )

    )

    (println (str inputname ": $"(format "%.2f" sum) ))

    )
  "5" (do
    (def inputitem (read-line))
    (def ^:dynamic itemsum 0)

    (doseq [n (keys saleList)]

    (if (= inputitem (get (get saleList n) :prodname))
    (do

      (def itemsum (+ itemsum  (Integer/parseInt (get (get saleList n) :itemcount)) ))
    )

    )
    )
    (println (str inputitem ": " itemsum))



    )
  "6" (do (println "good bye") (System/exit 0))
  )


    )
  ;  (println y)
    ))
