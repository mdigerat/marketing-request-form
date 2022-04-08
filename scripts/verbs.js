<script type='text/javascript'>//<![CDATA[
window.onload=function(){
var REM = "Bookmarking,Bulleting,Copying,Defining,Describing,Duplicating,Favouriting,Finding,Googling,Highlighting,Identifying,Liking,Labeling,Listeniing,Listing,Locating,Matching,Memorizing,Naming,Networking,Numbering,Quoting,Recalling,Leading,Reciting,Recognizing,Recording,Retelling,Repeating,Retrieving,Searching,Selecting,Tabulating,Telling,Visualizing";
var arrREM = REM.split(','),
    ul = document.getElementById("remembering");

for (var i = 0, len = arrREM.length; i < len; i++) {
    var li = document.createElement("li");
    var text = document.createTextNode(arrREM[i]);
    li.appendChild(text);
    ul.appendChild(li);
}

var UND = "Advanced Searching,Annotating,Associating,Boolean Searches,Categorizing,Classifying,Commenting,Comparing,Contrasting,Converting,Demonstrating,Describing,Differentiating,Discussing,Discovering,Distinguishing,Estimating,Exemplifying,Explaining,Expressing,Extending,Gathering,Generalizing,Grouping,Identifying,Indicating,Inferring,Interpreting,Journaling,Paraphrasing,Predicting,Relating,Subscribing,Summarizing,Tagging,Tweeting";
var arrUND = UND.split(','),
    ul = document.getElementById("understanding");

for (var i = 0, len = arrUND.length; i < len; i++) {
    var li = document.createElement("li");
    var text = document.createTextNode(arrUND[i]);
    li.appendChild(text);
    ul.appendChild(li);
}

var APP = "Acting Out,Administering,Applying,Articulating,Calculating,Carrying Out,Changing,Charting,Choosing,Collecting,Completing,Computing,Constructing,Demonstrating,Determining,Displaying,Examining,Executing,Explaning,Implementing,Interviewing,Judging,Editing,Experimenting,Hacking,Loading,Operating,Painting,Playing,Preparing,Presenting,Running,Sharing,Sketching,Uploading,Using";
var arrAPP = APP.split(','),
    ul = document.getElementById("applying");

for (var i = 0, len = arrAPP.length; i < len; i++) {
    var li = document.createElement("li");
    var text = document.createTextNode(arrAPP[i]);
    li.appendChild(text);
    ul.appendChild(li);
}

var ANA = "Advertising,Appraising,Attributing,Breaking Down,Calculating,Categorizing,Classifying,Comparing,Concluding,Contrasting,Correlating,Deconstructing,Deducing,Differentiating,Discriminating,Dividing,Distinguishing,Estimating,Explaining,Illustrating,Inferring,Integrating,Linking,Mashing,Mind Mapping,Ordering,Organizing,Outlining,Planning,Pointing Out,Prioritizing,Questioning,Separating,Structuring,Surveying";
var arrANA = ANA.split(','),
    ul = document.getElementById("analyzing");

for (var i = 0, len = arrANA.length; i < len; i++) {
    var li = document.createElement("li");
    var text = document.createTextNode(arrANA[i]);
    li.appendChild(text);
    ul.appendChild(li);
}

var EVA = "Arguing,Assessing,Checking,Criticizing,Commenting,Concluding,Considerring,Convincing,Critiquing,Debating,Defending,Detecting,Editorializing,Experimenting,Grading,Hypothesizing,Judging,Justifying,Measuring,Moderating,Monitoring,Networking,Persuading,Posting,Predicting,Rating,Recommending,Reflecting,Reframing,Reviewing,Revising,Scoring,Supporting,Testing,Validating";
var arrEVA = EVA.split(','),
    ul = document.getElementById("evaluating");

for (var i = 0, len = arrEVA.length; i < len; i++) {
    var li = document.createElement("li");
    var text = document.createTextNode(arrEVA[i]);
    li.appendChild(text);
    ul.appendChild(li);
}

var CRE = "Adapting,Animating,Blogging,Building,Collaborating,Composing,Constructing,Designing,Developing,Devising,Directing,Facilitating,Filming,Formulating,Integrating,Inventing,Leading,Making,Managing,Mixing/Remixing,Modifying,Negotiating,Originating,Orating,Planning,Podcasting,Producing,Programming,Publishing,Reole Playing,Simulating,Solving,Structuring,Video Blogging,Wiki Building,Writing";
var arrCRE = CRE.split(','),
    ul = document.getElementById("creating");

for (var i = 0, len = arrCRE.length; i < len; i++) {
    var li = document.createElement("li");
    var text = document.createTextNode(arrCRE[i]);
    li.appendChild(text);
    ul.appendChild(li);
}
}//]]> 

</script>