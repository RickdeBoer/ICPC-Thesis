visualiseYear<- function(ds, i,lim,penalty){
  # ds = a full dataframe taken from the database, where the columns are:
  #      "competitionyearid", "year", "solutionid","abbriviation","teamid","probleminfoid"
  #      "attempts", "time", "timespend". Only abbiviation, time & attempts are used.      
  # i = 1 till 129. A specific competitionyearid, which is a combination from a 
  #     competitionid and year.
  # lim = the maximum length of x axis, as some competitions have solutions beyond 300 minutes
  # penalty= TRUE/FALSE. Include penalty or not.
  
  if(missing(penalty)) {penalty=FALSE}
  if(missing(lim)) {lim=300}
  par(xpd=TRUE) #set outside plot range ON
  
  x <- ds[which(ds$competitionyearid==i ),c(4,7,8)] #extract only abbriviation, time & attempts
  x <- x[which(x$time > -1),] #keep only solutions, so remove where there is no time
  
  x$timeplusp <- x$time + x$attempts*20
  if(penalty == TRUE){
    x$bin <- cut(x$timeplusp, breaks=seq(0,lim,by=5));}
  else{
    x$bin <- cut(x$time, breaks=seq(0,lim,by=5));}
  
  colorframe<- matrix(c("red",'green','blue','cyan','purple','yellow','grey','orange', 
                        'darkblue','darkgreen', 'pink','darkred','brown','A','B','C','D','E',
                        'F','G','H','I','J','K','L','M'),nrow=13)
  colors <- colorframe[is.element(colorframe[,2], unique(x$abbriviation)),1];
  
  year<- ds[which(ds$competitionyearid==i),2]
  if(penalty ==TRUE){
    barplot(table(x[,c(4,5)]), col=colors,xlab = 'Time in minutes',ylab = 'Number of solves');}
  else{
    barplot(table(x[,c(1,5)]), col=colors,xlab = 'Time in minutes',ylab = 'Number of solves');}
  
  #legend("top", horiz = TRUE,legend=unique(x$abbriviation),fill=colors,inset=c(0.0,-0.11),bty = "n");
  title('Solves over time')
}
